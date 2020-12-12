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
        <div class="modal fade" id="delete-creative-modal" tabindex="-1" ref="closeButton" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Удаление</h5>
                        <button type="button" class="modal-close-button" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-window-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="modal-body-text">Вы действительно хотите удалить данное объявление?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal-button" data-dismiss="modal">Отмена</button>
                        <button type="button" class="modal-button" v-on:click="onDeleteCreative">Удалить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import * as network from "../../scripts/network";

    export default {
        name: "admin-room-delete-creative-modal",
        data() {
            return {
                creativeId: 0
            };
        },
        methods: {
            showMessageModal(type, title, description) {
                this.$root.$emit("show-message-modal", {
                    type: type,
                    title: title,
                    description: description
                });
            },
            onDeleteCreative() {
                this.$refs.closeButton.click();

                const self = this;
                network.removeCreativeById(this, this.creativeId, result => {
                    console.log(result);
                    self.$refs.closeButton.click();
                    if (result.result === 1) {
                        self.$root.$emit('deleted-creative-page', self.creativeId);
                        self.showMessageModal("info", "Успешная операция", "Объявление удалено");
                    } else {
                        self.showMessageModal("error", "Ошибка", "Объявление не было удалено");
                    }
                }, error => {
                    console.log(error);
                    self.$refs.closeButton.click();
                    self.showMessageModal("error", "Ошибка", "Объявление не было удалено");
                });
            }
        },
        created() {
            const self = this;
            this.$root.$on('click-delete-creative-page', (creativeId) => {
                self.creativeId = creativeId;
            });
        }
    }

</script>

<style scoped>

    .modal-close-button {
        border: none;
        padding: 0;
        outline: none;
        background-color: transparent;
        color: #10367B;
        font-size: 25px;
        float: right;
    }

    .modal-title {
        float: left;
        font-size: 21px;
        padding-top: 2px;
        font-family: 'Roboto', sans-serif;
    }

    .modal-body-text {
        color: #666666;;
        font-size: 16px;
        font-family: 'Open Sans', sans-serif;
        margin-bottom: 5px;
    }

    .modal-button {
        border: 1px solid white;
        outline: none;
        padding: 7px 21px 7px 21px;
        border-radius: 5px;
        font-size: 14px;
        font-family: 'Open Sans', sans-serif;
        color: white;
        background-color: transparent;
        transition: .3s;
    }

    .modal-button:hover {
        border: 1px solid #439EDC;
        color: #439EDC;
    }

    .modal-footer {
        padding-top: 15px;
        padding-bottom: 15px;
        background-color: #10367B;
    }

</style>