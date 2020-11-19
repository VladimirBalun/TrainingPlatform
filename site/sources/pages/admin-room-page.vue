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
        <div class="container">
            <div class="row">
                <admin-room-navigation-component class="col-lg-4 col-md-4 col-sm-5 col-xs-12"></admin-room-navigation-component>
                <admin-room-content-component v-for="creative in advertiserActiveCreatives" class="col-lg-4 col-md-4 col-sm-7 col-xs-12"
                    :id="creative.id" :title="creative.title" :image_url="creative.image_url" :event_date="creative.event_date"
                    :moderation_status="creative.moderation_status" :moderation_text="creative.moderation_text"
                    :brief_description="creative.brief_description">
                </admin-room-content-component>
            </div>
        </div>
    </div>
</template>

<script>

    import headerComponent from "../components/header-component";
    import adminRoomContentComponent from "../components/admin-room-content-component"
    import adminRoomNavigationComponent from "../components/admin-room-navigation-component";

    export default {
        name: "admin-room-page",
        components: {
            headerComponent,
            adminRoomContentComponent,
            adminRoomNavigationComponent
        },
        data() {
            return {
                advertiserActiveCreatives: []
            };
        },
        computed: {
            id() {
                return this.$route.params.id;
            }
        },
        methods: {
            fillAdvertiserCreatives() {
                const self = this;
                this.$http.get("http://localhost:8080/advertiser_demo_creative", { params: { advertiser_id: self.id } })
                    .then(response => {
                        console.log(response);
                        response.body.forEach(creative => {
                            self.advertiserActiveCreatives.push({
                                "id" : creative.id,
                                "title" : creative.title,
                                "brief_description" : creative.brief_description,
                                "image_url" : creative.image_url,
                                "event_date" : creative.event_date,
                                "moderation_status" : creative.moderation_status,
                                "moderation_text" : creative.moderation_text,
                            });
                        });
                    });
            },
        },
        created() {
            this.fillAdvertiserCreatives();
            this.$on('clickDeleteCreative', (creativeId) => {
                console.log(creativeId);
            });
        }
    }

</script>

<style scoped>

</style>