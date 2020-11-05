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
        <header-component></header-component>
        <diV class="main-page container">
            <div class="row">
                <navigation-component class="col-lg-4 col-md-4 hidden-sm hidden-xs"></navigation-component>
                <content-component v-for="creative in demoCreatives" class="col-lg-8 col-md-8 col-sm-12 col-xs-12"
                    :id="creative.id" :title="creative.title" :brief_description="creative.brief_description"
                    :image_url="creative.image_url" :event_date="creative.event_date" :price="creative.price">
                </content-component>
            </div>
        </diV>
        <footer-component></footer-component>
    </div>
</template>

<script>

    "use strict";

    import headerComponent from "../components/header-component";
    import footerComponent from "../components/footer-component";
    import contentComponent from "../components/content-component";
    import navigationComponent from "../components/navigation-component.vue";

    export default {
        components: {
            headerComponent,
            footerComponent,
            contentComponent,
            navigationComponent
        },
        data() {
            return {
                demoCreatives: []
            };
        },
        methods: {
            fillDemoCreatives() {
              const self = this;
              this.$http.get("http://localhost:8080/demo_creatives")
                  .then(response => {
                    console.log(response);
                      response.body.forEach(creative => {
                          console.log(creative.image_url);
                          self.demoCreatives.push({
                              "id" : creative.id,
                              "title" : creative.title,
                              "brief_description" : creative.brief_description,
                              "image_url" : creative.image_url,
                              "event_date" : creative.event_date,
                              "price" : creative.price,
                          })
                      });
                  });
            }
        },
        created() {
            this.fillDemoCreatives();
        }
    };

</script>

<style scoped>

    .main-page {
        margin-top: 30px;
    }

</style>