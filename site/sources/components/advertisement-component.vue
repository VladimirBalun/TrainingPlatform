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
        <div class="advertisement-block-wrapper">
            <div class="advertisement-block">
                <img class="advertisement-image" src="https://texterra.ru/upload/iblock/fbf/socialprev.jpg">
            </div>
            <div class="advertisement-block">
                <img class="advertisement-image" src="https://texterra.ru/upload/iblock/fbf/socialprev.jpg">
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "advertisement-component"
    }

</script>

<style scoped>

    .advertisement-block-wrapper {
        margin-bottom: 30px;
    }

    .advertisement-block {
        margin-top: 30px;
    }

    .advertisement-image {
        position: relative;
        width: 100%;
        border-radius: 5px;
    }

    @media(max-width:767px) {

      .advertisement-block {
          margin: 0 0 15px 0;
      }

    }

</style>