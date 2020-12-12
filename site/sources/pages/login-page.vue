<!--
- Copyright 2018 Vladimir Balun
-
- Licensed under the Apache License, Version 2.0 (the "License");
- you may not use this file except in compliance with the License.
- You may obtain a copy of the License at
-
-     http://www.apache.org/licenses/LICENSE-2.0
-
- Unless required by applicable law or agreed to in writing, software
- distributed under the License is distributed on an "AS IS" BASIS,
- WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
- See the License for the specific language governing permissions and
- limitations under the License.
-->

<template>
    <div class="page">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <form class="login-form block">
                        <p class="login-logo-wrapper">
                            <img class="login-logo" alt="logo" src="http://mysite.local/trening/site/sources/assets/images/logo.png">
                        </p>
                        <p class="login-title">Авторизация</p>
                        <p class="login-error-message" v-show="errorMessage !== ''">{{ errorMessage }}</p>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input class="login-input" type="text" id="login-email" maxlength="320" placeholder="Введите e-mail"
                                 v-model="model.email" v-bind:class="{ 'error-input': !validation.email }">
                        </div>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input class="login-input" type="password" id="login-password" maxlength="128" placeholder="Введите пароль"
                                 v-model="model.password" v-bind:class="{ 'error-input': !validation.password }">
                        </div>
                        <button @click="onLoginButtonClick" :disabled="loginInProgress">Войти</button>
                        <p class="login-login">
                            <label>Нет аккаунта? <router-link to="/signup" class="header-link">Регистрация</router-link></label>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    "use strict";


    import _ from "underscore"
    import * as network from "../scripts/network";
    import * as protocol from '../scripts/protocol';
    import * as validation from "../scripts/validation";

    export default {
      name: "login-page",
      data() {
          return {
              model: {
                  email: "",
                  password: ""
              },
              validation: {
                  email: true,
                  password: true
              },
              loginInProgress: false,
              errorMessage: ""
          };
      },
      methods: {
          onLoginButtonClick() {
              let loginForm = {
                  model: this.model,
                  validation: this.validation
              };

              this.errorMessage = validation.validateLoginForm(loginForm)
              if (this.errorMessage !== "") {
                  return;
              }

              const self = this;
              this.loginInProgress = true;
              network.loginAdvertiser(this, _.clone(this.model), response => {
                  console.log(response);
                  const status = response.status;
                  switch (status) {
                      case protocol.LOGIN_SUCCESS: {
                          self.$router.push('/admin_room/' + response.advertiser_id);
                          break;
                      }
                      case protocol.LOGIN_ERROR_INCORRECT_EMAIL: {
                          self.validation.email = false;
                          self.errorMessage = "Некорректный e-mail";
                          break;
                      }
                      case protocol.LOGIN_ERROR_INCORRECT_PASSWORD: {
                          self.validation.password = false;
                          self.errorMessage = "Некорректный пароль";
                          break;
                      }
                      case protocol.LOGIN_ERROR_INCORRECT_EMAIL_OR_PASSWORD: {
                          self.validation.email = false;
                          self.validation.password = false;
                          self.errorMessage = "Неверный e-mail или пароль";
                          break;
                      }
                      default: {
                          self.validation.email = false;
                          self.validation.password = false;
                          self.errorMessage = "Пользователь не был авторизован из-за неизвестной ошибки, " +
                              "попробуйте повторить вашу попытку позже...";
                          break;
                      }
                  }
                  self.loginInProgress = false;
              }, error => {
                  console.log(error);
                  self.loginInProgress = false;
                  self.validation.email = false;
                  self.validation.password = false;
                  self.errorMessage = "Пользователь не был авторизован, возможно из-за ошибки, " +
                      "связанной с сетевым соединением, попробуйте повторить вашу попытку позже...";
              });
            }
        }
    }

</script>

<style scoped>

    .page {
        height: 100%;
        position: relative;
        background-color: #363636;
        display: flex;
        align-items: center;
    }

    .container {
        background-color: #363636;
    }

    .login-logo-wrapper {
        text-align: center;
    }

    .login-logo {
        width: 140px;
        margin-bottom: 20px;
        height: auto;
    }

    .login-title {
        text-align: center;
        font-family: 'Roboto', sans-serif;
        font-size: 25px;
        margin-bottom: 30px;
    }

    .login-form {
        padding: 60px 100px 50px 100px;
        margin-bottom: 15px;
    }

    label {
        display: inline;
        font-weight: normal;
        font-family: 'Open Sans', sans-serif;
        font-size: 13px;
        color: #808080;
    }

    input[type="checkbox"] {
        transform: translateY(1px);
    }

    .login-input  {
        border: none;
        width: 100%;
        display: block;
        border-radius: 5px;
        background-color: #EEF3F8;
        font-size: 14px;
        padding: 13px 15px 13px 43px;
        font-family: 'Open Sans', sans-serif;
        margin-bottom: 10px;
    }

    .input-wrapper {
        position: relative;
    }

    .fas {
        position: absolute;
        top: 14px;
        left: 15px;
        font-size: 18px;
        color: #C0C0C0;
    }

    button {
        width: 100%;
        font-size: 16px;
        background-color: #2D71BC;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 10px 10px 10px;
        font-family: 'Open Sans', sans-serif;
        transition: .3s;
    }

    button:hover {
        outline: none;
        background-color: #193777;
    }

    .login-login {
        margin-top: 30px;
        text-align: center;
    }

    .login-error-message {
        font-family: 'Open Sans', sans-serif;
        text-align: center;
        color: #d92626;
        font-size: 14px;
        padding: 13px 15px 13px 15px;
        background-color: #ffe6e6;
        border-radius: 5px;
        margin-top: 20px;
    }

    .error-input {
        border: 2px solid #d92626;
        background-color: #ffe6e6;
    }

    @media(max-width:767px) {

        .login-form {
            margin-top: 15px;
            padding: 70px 30px 70px 30px;
        }

        .page {
            display: block;
        }

    }

</style>