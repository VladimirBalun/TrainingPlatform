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
    <div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    <form class="signup-form block">
                        <p class="signup-icon"><i class="fas fa-user-circle"></i></p>
                        <label for="signup-username"><label class="signup-require-color">*</label> Введите имя пользователя:</label>
                        <input class="signup-input" type="text" id="signup-username"
                            v-model="usernameModel" v-bind:class="{ 'error-input': !isValidUsername }">
                        <label for="signup-email"><label class="signup-require-color">*</label> Введите e-mail:</label>
                        <input class="signup-input" type="text" id="signup-email"
                            v-model="emailModel" v-bind:class="{ 'error-input': !isValidEmail }">
                        <label for="signup-password"><label class="signup-require-color">*</label> Введите пароль:</label>
                        <input class="signup-input" type="password" id="signup-password"
                            v-model="passwordModel" v-bind:class="{ 'error-input': !isValidPassword }">
                        <label for="signup-privacy"><label class="signup-require-color">*</label> Принимаю условия политики конфиденциальности</label>
                        <input type="checkbox" id="signup-privacy">
                        <button @click="onSignupButtonClick">Зарегистрироваться</button>
                        <p>{{ errorMessage }}</p>
                        <p class="signup-login"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    "use strict";

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
                    this.errorMessage = "Неверное имя пользователя, " +
                        "допустимо использование только латинских букв с цифрами, например advertiser123"
                    return false;
                }

                const regexForEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (regexForEmail.test(String(this.emailModel).toLowerCase())) {
                    this.isValidEmail = true;
                } else {
                    this.isValidEmail = false;
                    this.errorMessage = "Неверный e-mail, e-mail должен иметь стандартный вид, например advertiser@ad.ru"
                    return false;
                }
            },
            onSignupButtonClick() {
                this.errorMessage = "";
                if (!this.checkFormOnEmpty()) {
                    return;
                }
                if (!this.checkFormValidation()) {
                    return;
                }

                const SIGNUP_SUCCESS = 0;
                const USERNAME_BUSY_ERROR = 1;
                const EMAIL_BUSY_ERROR = 2;
                const UNKNOWN_ERROR = 3;

                const self = this;
                this.$http.post("http://localhost:8080/advertisers/signup",
                    { params: { username: self.usernameModel, email: self.emailModel, password: self.passwordModel } })
                    .then(response => {
                        const status = response.status;
                        switch (status) {
                            case SIGNUP_SUCCESS: {

                                break;
                            }
                            case USERNAME_BUSY_ERROR: {
                                self.isValidUsername = false;
                                self.errorMessage = "Пользователь с таким именем уже существует";
                                break;
                            }
                            case EMAIL_BUSY_ERROR: {
                                self.isValidEmail = false;
                                self.errorMessage = "Пользователь с таким e-mail уже существует";
                                break;
                            }
                            case UNKNOWN_ERROR: {
                                self.isValidUsername = false;
                                self.isValidEmail = false;
                                self.isValidPassword = false;
                                self.errorMessage = "Пользователь не был зарегистрирован, неверно введены данные";
                                break;
                            }
                        }
                    }, error => {
                        self.isValidUsername = false;
                        self.isValidEmail = false;
                        self.isValidPassword = false;
                        self.errorMessage = "Пользователь не был зарегистрирован, неверно введены данные";
                    });
            }
        }
    }

</script>

<style scoped>

    .signup-form {
        margin-top: 150px;
        padding: 70px 80px 80px 80px;
    }

    label {
        font-weight: normal;
        font-family: 'Open Sans', sans-serif;
        font-size: 14px;
        color: #666666;
        margin-top: 10px;
    }

    .signup-icon {
        text-align: center;
        font-size: 100px;
        color: #e08d3c;
    }

    .signup-input  {
        border: none;
        width: 100%;
        display: block;
        border-radius: 5px;
        background-color: #EEF3F8;
        font-size: 16px;
        padding: 10px 15px 10px 15px;
        font-family: 'Open Sans', sans-serif;
    }

    .signup-require-color {
        color: #d92626;
    }

    .error-input {
        border: 2px solid #d92626;
        background-color: #ffe6e6;
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


</style>