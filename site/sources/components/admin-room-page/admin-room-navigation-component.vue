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
    <div class="admin-room-navigation-wrapper">
        <div class="admin-room-block block">
            <p class="admin-room-navigation-advertiser-image-wrapper">
                <img class="admin-room-navigation-advertiser-image" ref="advertiserImage" @error="onImageLoadFailure($event)" alt="advertiser_img" :src="advertiserImageUrl">
            </p>
            <input v-model="advertiserImageUrlModel" class="admin-room-navigation-input" type="text" placeholder="Введите адрес изображения..." maxlength="2083">
            <button @click="onChangeAdvertiserImageForm" class="admin-room-navigation-button">Сменить изображение</button>
        </div>
        <div class="admin-room-block block">
            <button data-toggle="modal" data-target="#add-creative-modal" class="admin-room-navigation-button">Добавить объявление</button>
        </div>
        <div class="admin-room-block block hidden-xs">
            <p class="admin-room-navigation-title"><i class="fas fa-comment-dots"></i>Информация</p><hr>
            <p class="admin-room-navigation-link">По сотрудничеству: <a href="mailto:vladimirbalun@yandex.ru">написать</a></p>
            <p class="admin-room-navigation-link">По техническим причинам: <a href="mailto:vladimirbalun@yandex.ru">написать</a></p>
        </div>
        <advertisement-component class="hidden-xs"></advertisement-component>
    </div>
</template>

<script>

    import * as network from "../../scripts/network";
    import * as common from "../../scripts/common";

    import advertisementComponent from "../advertisement-component";

    export default {
        name: "admin-room-navigation-component",
        props: ["id", "advertiserImageUrl"],
        components: {
            advertisementComponent
        },
        data() {
            return {
                advertiserImageUrlModel: ""
            };
        },
        methods: {
            onImageLoadFailure (event) {
                event.target.src = common.defaultUserImage;
            },
            showMessageModal(type, title, description) {
                this.$root.$emit("show-message-modal", {
                    type: type,
                    title: title,
                    description: description
                });
            },
            onChangeAdvertiserImageForm() {
                if (this.advertiserImageUrlModel === "") {
                    this.showMessageModal("error","Ошибка", "Адрес изображения не может быть пустым");
                    return false;
                }

                const regex = /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i;
                if (!regex.test(this.advertiserImageUrlModel)) {
                    this.showMessageModal("error","Ошибка", "Некорректный адрес изображения");
                    return false;
                }

                const self = this;
                network.changeAdvertiserImageUrlById(this, this.id, this.advertiserImageUrlModel.trim(), result => {
                    console.log(result);
                    if (result.result === 1) {
                        this.$refs.advertiserImage.src = self.advertiserImageUrlModel;
                        self.advertiserImageUrlModel = "";
                        self.showMessageModal("info","Успешная операция", "Изображение пользователя изменено");
                    } else {
                        self.showMessageModal("error","Ошибка", "Изображение пользователя не было изменено");
                    }
                }, error => {
                    console.log(error);
                    self.showMessageModal("error","Ошибка", "Изображение пользователя не было изменено");
                })
            }
        }
    }

</script>

<style scoped>

    .admin-room-navigation-wrapper {
        margin-bottom: 30px;
    }

    .admin-room-block {
        margin-top: 30px;
    }

    .admin-room-navigation-button {
        border: none;
        outline: none;
        text-align: center;
        display: block;
        font-size: 16px;
        text-decoration: none;
        background-color: #2D71BC;
        color: white;
        border-radius: 5px;
        padding: 7px 30px 7px 30px;
        font-family: 'Open Sans', sans-serif;
        transition: .3s;
        margin: 20px;
        width: calc(100% - 40px);
    }

    .admin-room-navigation-button:hover {
        text-decoration: none;
        background-color: #10367B;
    }

    .admin-room-navigation-input {
        border: none;
        display: block;
        margin: 20px 20px 0 20px;
        border-radius: 5px;
        background-color: #EEF3F8;
        font-size: 16px;
        padding: 10px 15px 10px 15px;
        font-family: 'Open Sans', sans-serif;
        width: calc(100% - 40px);
    }

    .admin-room-navigation-advertiser-image-wrapper {
        text-align: center;
    }

    .admin-room-navigation-advertiser-image {
        margin-top: 20px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        object-position: 50% 50%;
    }

    .fa-comment-dots {
        font-size: 15px;
        margin-right: 10px;
        transform: translateY(-1px);
    }

    .admin-room-navigation-title {
        color: black;
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
        font-size: 20px;
        padding: 15px 20px 0 20px;
    }

    .admin-room-navigation-link {
        font-family: 'Open Sans', sans-serif;
        font-size: 15px;
        padding-top: 0;
        margin: 0 20px 20px 20px;
    }

    @media(max-width:767px) {

        .admin-room-block {
            margin-top: 15px;
        }

        .admin-room-navigation-wrapper {
            margin-bottom: 0;
        }

    }

</style>