<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Mailbox</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card-outline card card-primary">
              <div class="card-header">
                <h3 class="card-title">
                  My Mailbox
                  <button
                    class="btn btn-sm btn-outline-primary"
                    data-toggle="modal"
                    data-target="#messageModal"
                  >
                    Send
                    <i class="fa fa-paper-plane"></i>
                  </button>
                  <button @click="loadChats" class="btn btn-sm btn-secondary pull-right">
                    <b-spinner small v-if="spinner4" type="grow" label="Spinning"></b-spinner>
                    <small v-else>
                      <b>Refresh</b>
                    </small>
                  </button>
                </h3>
              </div>
              <div class="card-body">
                <div class="table-responsive mailbox-messages">
                  <b-table-simple hover small caption-top responsive>
                    <caption>My Chats</caption>
                    <colgroup>
                      <col />
                      <col />
                      <col />
                    </colgroup>
                    <b-tbody>
                      <b-tr v-for="chat in chats" :key="chat.id">
                        <b-th class="text-primary">
                          <a
                            href="#"
                            @click.prevent="loadChat(chat.reply.message_id)"
                          >{{ chat.correspondent.fname + ' ' + chat.correspondent.lname }}</a>
                        </b-th>
                        <b-td
                          :class="{ 'text-primary': chat.reply.status=='unread'}"
                          class="mailbox-subject"
                        >{{ truncate(chat.reply.message) }}</b-td>
                        <b-td class="text-right text-secondary">
                          <small>{{ chat.reply.created_at }}</small>
                        </b-td>
                      </b-tr>
                    </b-tbody>
                  </b-table-simple>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card-outline card card-secondary">
              <div class="card-header">
                <h3 class="card-title">
                  Chat
                  <!-- <b-spinner v-if="spinner2" variant="primary" type="grow" label="Spinning"></b-spinner> -->
                  <button v-if="chat.length > 0" @click="loadChat(message_id)" class="btn btn-sm btn-secondary pull-right">
                    <b-spinner small v-if="spinner2" type="grow" label="Spinning"></b-spinner>
                    <small v-else>
                      <b>Refresh</b>
                    </small>
                  </button>
                </h3>
              </div>
              <div class="card-body">
                <div class="direct-chat-messages" style="height:300px">
                  <div v-for="ch in chat" :key="ch.id">
                    <div v-if="ch.recipient.id == auth.id" class="direct-chat-msg">
                      <div class="direct-chat-info clearfix">
                        <span
                          class="direct-chat-name float-left"
                        >{{ ch.sender.fname + ' ' + ch.sender.lname }}</span>
                        <span class="direct-chat-timestamp float-right">{{ ch.date_sent }}</span>
                      </div>

                      <img
                        v-if="ch.sender.profile_picture"
                        class="direct-chat-img"
                        :src="'/storage/' + ch.sender.profile_picture"
                        alt="message user image"
                      />
                      <img
                        v-else
                        class="direct-chat-img"
                        :src="'https://ui-avatars.com/api/?name=' + ch.sender.fname + '+' + ch.sender.lname"
                        alt="message user image"
                      />

                      <div class="direct-chat-text">
                        {{ ch.message }}
                        <span v-if="ch.attachment" class="pull-right">
                          <i class="fa fa-paperclip"></i>
                          <a :href="'/storage/attachments/' + ch.attachment">
                            <i class="fa fa-download"></i>
                          </a>
                        </span>
                      </div>
                    </div>
                    <div v-else class="direct-chat-msg right">
                      <div class="direct-chat-info clearfix">
                        <span
                          class="direct-chat-name float-right"
                        >{{ ch.sender.fname + ' ' + ch.sender.lname }}</span>
                        <span class="direct-chat-timestamp float-left">{{ ch.date_sent }}</span>
                      </div>
                      <img
                        v-if="ch.sender.profile_picture"
                        class="direct-chat-img"
                        :src="'/storage/' + ch.sender.profile_picture"
                        alt="message user image"
                      />
                      <img
                        v-else
                        class="direct-chat-img"
                        :src="'https://ui-avatars.com/api/?name=' + ch.sender.fname + '+' + ch.sender.lname"
                        alt="message user image"
                      />
                      <div class="direct-chat-text bg-primary">
                        {{ ch.message }}
                        <span v-if="ch.attachment" class="pull-right">
                          <i class="fa fa-paperclip"></i>
                          <a :href="'/storage/attachments/' + ch.attachment">
                            <i class="fa fa-download"></i>
                          </a>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer" v-if="chat.length > 0">
                <div class="input-group">
                  <!-- <ckeditor :editor="editor" v-model="message.message" :config="editorConfig"></ckeditor> -->
                  <input
                    type="text"
                    name="message"
                    @focus="setRecipient"
                    v-model="message.message"
                    class="form-control"
                    placeholder="Type Message...."
                  />
                  <span class="input-group-append">
                    <button type="submit" @click="send" class="btn btn-primary">
                      <b>Send</b>
                      <span
                        v-if="spinner"
                        class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true"
                      ></span>
                    </button>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div
            class="modal fade"
            id="messageModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
          >
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Send Message</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">To</label>
                    <select class="form-control" v-model="message.recipient_id">
                      <option disabled value="1">Select Recipient</option>
                      <option
                        v-for="user in users"
                        :key="user.id"
                        :value="user.id"
                      >{{ user.fname + ' ' + user.lname }}</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Message</label>
                    <textarea
                      v-model="message.message"
                      class="form-control"
                      cols="3"
                      placeholder="Type message..."
                      rows="3"
                    ></textarea>
                    <!-- <ckeditor :editor="editor"  :config="editorConfig"></ckeditor> -->
                  </div>
                  <div class="form-group">
                    <label for>
                      Attachment
                      <i class="fa fa-paperclip"></i>
                    </label>
                    <b-form-file
                      accept=".docx, .doc, .pdf, .xls, .xlsx, .txt, .jpeg, .jpg, .png, .gif"
                      v-model="message.attachment"
                      ref="att"
                      class="mb-2"
                    ></b-form-file>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button @click="send" class="btn btn-primary">
                    <i class="fa fa-paper-plane"></i>
                    Send
                    <span
                      v-if="spinner"
                      class="spinner-border spinner-border-sm"
                      role="status"
                      aria-hidden="true"
                    ></span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import * as api from "../api/api";
import { mapMutations, mapState } from "vuex";
// import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
  data() {
    return {
      spinner: false,
      spinner2: false,
      spinner4: false,
      message_id: null,
      message: {
        recipient_id: null,
        message: null,
        attachment: null
      },
      data: new FormData()
    };
  },

  methods: {
    ...mapMutations({
      setUsers: "setUsers",
      setChats: "setChats",
      setChat: "setChat"
    }),
    // removeHtml(text) {
    //   var regex = /(<([^>]+)>)/gi;
    //   return text.replace(regex, "");
    // },
    setRecipient() {
      if (this.chat[0].sender.id == this.auth.id) {
        this.message.recipient_id = this.chat[0].recipient.id;
      }
      if (this.chat[0].recipient.id == this.auth.id) {
        this.message.recipient_id = this.chat[0].sender.id;
      }
    },
    truncate(truncated) {
      let maxLength = 15;
      if (truncated.length > maxLength) {
        truncated = truncated.substr(0, maxLength) + "...";
      }
      return truncated;
    },
    loadChat(id) {
      this.message_id = id;
      this.spinner2 = true;
      api.loadChat(id).then(response => {
        this.setChat(response.data);
        this.loadChats();
        this.spinner2 = false;
      });
    },
    showToast(variant, title, body) {
      this.$bvToast.toast(body, {
        title: title,
        variant: variant,
        solid: true
      });
    },
    uploadFile() {
      this.message.attachment = this.$refs.att.files[0];
    },
    send() {
      this.spinner = true;
      if (!this.message.recipient_id) {
        this.showToast("danger", "Error", "Please select a recipient");
        this.spinner = false;
        return;
      }
      if (!this.message.message) {
        this.showToast("danger", "Error", "Please enter a message");
        this.spinner = false;
        return;
      }

      this.data.append("message", this.message.message);
      this.data.append("attachment", this.message.attachment);
      this.data.append("recipient_id", this.message.recipient_id);

      api.sendMessage(this.data).then(response => {
        if (!response.success) {
          this.showToast("danger", "Error", response.data.error);
          this.spinner = false;
          this.$refs.att.reset();
          return;
        }
        this.message.message = null;
        this.data = new FormData();
        this.showToast("success", "Notification", "Message has been sent");
        this.loadChat(response.data.id);
        this.spinner = false;
      });
    },
    loadChats() {
      this.spinner4 = true;
      api.getChats().then(response => {
        this.setChats(response.data);
        this.spinner4 = false;
      });
    },
    loadUsers() {
      api.getUsers().then(response => {
        let users = response.data.filter(user => user.id != this.auth.id);
        this.setUsers(users);
      });
    }
  },
  computed: {
    ...mapState({
      auth: state => state.auth,
      users: state => state.users,
      chats: state => state.chats,
      chat: state => state.chat
    })
  },
  mounted() {
    this.loadUsers();
    this.loadChats();
  }
};
</script>

<style >
</style>
