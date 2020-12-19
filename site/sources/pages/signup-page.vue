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
                        <p class="signup-logo-wrapper">
                            <img class="signup-logo" alt="logo" src="http://mysite.local/trening/site/sources/assets/images/logo.png">
                        </p>
                        <p class="signup-title">Регистрация</p>
                        <p class="signup-error-message" v-show="errorMessage !== ''">{{ errorMessage }}</p>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input class="signup-input" type="text" id="signup-username" maxlength="64" placeholder="Введите имя пользователя"
                                 v-model="model.username" v-bind:class="{ 'error-input': !validation.username }">
                        </div>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input class="signup-input" type="text" id="signup-email" maxlength="320" placeholder="Введите e-mail"
                                v-model="model.email" v-bind:class="{ 'error-input': !validation.email }">
                        </div>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input class="signup-input" type="password" id="signup-password" maxlength="128" placeholder="Введите пароль"
                                v-model="model.password" v-bind:class="{ 'error-input': !validation.password }">
                        </div>
                        <input type="checkbox" id="signup-privacy" v-model="model.privacyPolicy">
                        <label for="signup-privacy">Принимаю условия <a href="./privacy_policy.html">политики конфиденциальности</a></label>
                        <button @click="onSignupButtonClick" :disabled="signupInProgress">Зарегистрироваться</button>
                        <p class="signup-login">
                            <label>Уже есть аккаунт? <router-link to="/login" class="header-link">Авторизация</router-link></label>
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
    import _ from "underscore";
    import * as network from "../scripts/network";
    import * as protocol from "../scripts/protocol";
    import * as validation from "../scripts/validation";

    export default {
        name: "signup-page",
        data() {
            return {
                model: {
                    username: "",
                    email: "",
                    password: "",
                    privacyPolicy: false
                },
                validation: {
                    username: true,
                    email: true,
                    password: true,
                    privacyPolicy: true
                },
                signupInProgress: false,
                errorMessage: ""
            };
        },
        methods: {
            onSignupButtonClick() {
                let signupForm = {
                    model: this.model,
                    validation: this.validation
                };

                this.errorMessage = validation.validateSignupForm(signupForm)
                if (this.errorMessage !== "") {
                    return;
                }

                const self = this;
                this.signupInProgress = true;
                network.signupAdvertiser(this, _.clone(signupForm.model), response => {
                    console.log(response);
                    const status = response.status;
                    switch (status) {
                        case protocol.SIGNUP_SUCCESS: {
                            self.$router.push("/admin_room/" + response.advertiser_id);
                            break;
                        }
                        case protocol.SIGNUP_ERROR_USERNAME_EXISTS: {
                            self.validation.username = false;
                            self.errorMessage = "Пользователь с таким именем уже существует";
                            break;
                        }
                        case protocol.SIGNUP_ERROR_EMAIL_EXISTS: {
                            self.validation.email = false;
                            self.errorMessage = "Пользователь с таким e-mail уже существует";
                            break;
                        }
                        case protocol.SIGNUP_ERROR_INCORRECT_USERNAME: {
                            self.validation.username = false;
                            self.errorMessage = "Некорректное имя пользователя";
                            break;
                        }
                        case protocol.SIGNUP_ERROR_INCORRECT_EMAIL: {
                            self.validation.email = false;
                            self.errorMessage = "Некорректный e-mail";
                            break;
                        }
                        case protocol.SIGNUP_ERROR_INCORRECT_PASSWORD: {
                            self.validation.password = false;
                            self.errorMessage = "Некорректный пароль";
                            break;
                        }
                        case protocol.SIGNUP_NEED_LOGIN: {
                            self.$router.push("/login");
                            break;
                        }
                        default: {
                            self.validation.username = false;
                            self.validation.email = false;
                            self.validation.password = false;
                            self.errorMessage = "Пользователь не был зарегистрирован из-за неизвестной ошибки, " +
                                "попробуйте повторить вашу попытку позже...";
                            break;
                        }
                    }
                    self.signupInProgress = false;
                }, error => {
                    console.log(error);
                    self.signupInProgress = false;
                    self.validation.username = false;
                    self.validation.email = false;
                    self.validation.password = false;
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
        min-height: 100vh;
        position: relative;
        background-color: #363636;
        display: flex;
        align-items: center;
    }

    .container {
        background-color: #363636;
    }

    .signup-logo-wrapper {
        text-align: center;
    }

    .signup-logo {
        width: 140px;
        margin-bottom: 20px;
        height: auto;
    }

    .signup-title {
        text-align: center;
        font-family: 'Roboto', sans-serif;
        font-size: 25px;
        margin-bottom: 30px;
    }

    .signup-form {
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

        .page {
            display: block;
        }

    }

</style>