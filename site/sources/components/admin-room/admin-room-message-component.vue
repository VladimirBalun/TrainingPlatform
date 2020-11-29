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
        <div class="modal fade" id="message-modal" tabindex="-1" ref="closeButton" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ title }}</h5>
                        <button type="button" class="modal-close-button" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-window-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="modal-body-text">{{ description }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal-button" data-dismiss="modal">Ок</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "admin-room-message-component",
        props: ["title", "description"]
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