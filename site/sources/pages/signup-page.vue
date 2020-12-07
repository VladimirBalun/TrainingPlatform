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
                    <form class="signup-form block">
                        <p class="signup-title">Регистрация</p>
                        <p class="signup-error-message" v-show="errorMessage !== ''">{{ errorMessage }}</p>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input class="signup-input" type="text" id="signup-username" maxlength="64" placeholder="Введите имя пользователя"
                                 v-model="usernameModel" v-bind:class="{ 'error-input': !isValidUsername }">
                        </div>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input class="signup-input" type="text" id="signup-email" maxlength="320" placeholder="Введите e-mail"
                                v-model="emailModel" v-bind:class="{ 'error-input': !isValidEmail }">
                        </div>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input class="signup-input" type="password" id="signup-password" maxlength="128" placeholder="Введите пароль"
                                v-model="passwordModel" v-bind:class="{ 'error-input': !isValidPassword }">
                        </div>
                        <input type="checkbox" id="signup-privacy">
                        <label for="signup-privacy">Принимаю условия <a href="">политики конфиденциальности</a></label>
                        <button @click="onSignupButtonClick">Зарегистрироваться</button>
                        <p class="signup-login">
                            <label>Уже есть аккаунт? <a href="">Авторизация</a></label>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    "use strict";

    import MD5 from "crypto-js/md5";
    import * as protocol from '../scripts/protocol'

    export default {
        name: "signup-page",
        data() {
            return {
                usernameModel: "",
                emailModel: "",
                passwordModel: "",
                isValidUsername: true,
                isValidEmail: true,
                isValidPassword: true,
                errorMessage: ""
            };
        },
        methods: {
            checkFormOnEmpty() {
                if (this.usernameModel !== "") {
                    this.isValidUsername = true;
                } else {
                    this.isValidUsername = false;
                    this.errorMessage = "Имя пользователя не может быть пустым"
                    return false;
                }

                if (this.emailModel !== "") {
                    this.isValidEmail = true;
                } else {
                    this.isValidEmail = false;
                    this.errorMessage = "E-mail не может быть пустым"
                    return false;
                }

                if (this.passwordModel !== "") {
                    this.isValidPassword = true;
                } else {
                    this.isValidPassword = false;
                    this.errorMessage = "Пароль не может быть пустым";
                    return false;
                }

                return true;
            },
            checkFormValidation() {
                const regexForUsername = /^[a-zA-Z0-9]+$/;
                if (regexForUsername.test(String(this.usernameModel).toLowerCase())) {
                    this.isValidUsername = true;
                } else {
                    this.isValidUsername = false;
                    this.errorMessage = "Некорректное имя пользователя";
                    return false;
                }

                const regexForEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (regexForEmail.test(String(this.emailModel).toLowerCase())) {
                    this.isValidEmail = true;
                } else {
                    this.isValidEmail = false;
                    this.errorMessage = "Некорректный e-mail";
                    return false;
                }

                return true;
            },
            onSignupButtonClick() {
                this.errorMessage = "";
                this.usernameModel = this.usernameModel.trim();
                this.emailModel = this.emailModel.trim();
                this.passwordModel = this.passwordModel.trim();

                if (!this.checkFormOnEmpty()) {
                    return;
                }
                if (!this.checkFormValidation()) {
                    return;
                }

                const self = this;
                this.$http.post("http://localhost:8080/advertisers_signup",
                    {
                              username: self.usernameModel,
                              email: self.emailModel,
                              password: MD5(self.passwordModel)
                          })
                    .then(response => {
                        console.log(response);
                        const status = response.status;
                        switch (status) {
                            case protocol.SIGNUP_SUCCESS: {
                                alert("Успешная регистрация");
                                break;
                            }
                            case protocol.SIGNUP_ERROR_USERNAME_EXISTS: {
                                self.isValidUsername = false;
                                self.errorMessage = "Пользователь с таким именем уже существует";
                                break;
                            }
                            case protocol.SIGNUP_ERROR_EMAIL_EXISTS: {
                                self.isValidEmail = false;
                                self.errorMessage = "Пользователь с таким e-mail уже существует";
                                break;
                            }
                            case protocol.SIGNUP_ERROR_INCORRECT_USERNAME:
                                self.isValidUsername = false;
                                self.errorMessage = "Пользователь не был зарегистрирован, некорректное имя пользователя";
                                break;
                            case protocol.SIGNUP_ERROR_INCORRECT_EMAIL:
                                self.isValidEmail = false;
                                self.errorMessage = "Пользователь не был зарегистрирован, некорректный e-mail";
                                break;
                            case protocol.SIGNUP_ERROR_INCORRECT_PASSWORD:
                                self.isValidEmail = false;
                                self.errorMessage = "Пользователь не был зарегистрирован, некорректный пароль";
                                break;
                            case protocol.SIGNUP_ERROR_UNKNOWN: {
                                self.isValidUsername = false;
                                self.isValidEmail = false;
                                self.isValidPassword = false;
                                self.errorMessage = "Пользователь не был зарегистрирован из-за неизвестной ошибки, " +
                                    "попробуйте повторить вашу попытку позже...";
                                break;
                            }
                        }
                    }, error => {
                        console.log(error);
                        self.isValidUsername = false;
                        self.isValidEmail = false;
                        self.isValidPassword = false;
                        self.errorMessage = "Пользователь не был зарегистрирован возможно из-за ошибки, " +
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

    .signup-title {
        text-align: center;
        font-family: 'Roboto', sans-serif;
        font-size: 25px;
        margin-bottom: 30px;
    }

    .signup-form {
       padding: 60px 100px 50px 100px;
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

    .signup-input  {
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
        margin-top: 10px;
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

    .signup-login {
        margin-top: 30px;
        text-align: center;
    }

    .signup-error-message {
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

        .signup-form {
            margin-top: 15px;
            padding: 70px 30px 70px 30px;
        }

    }

</style>