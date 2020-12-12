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
        <div v-show="proposedDemoCreatives.length >= 3">
            <p class="proposed-creatives-title col-lg-12 col-md-12 col-sm-12 col-xs-12">Другие объявления</p>
            <content-component v-for="creative in proposedDemoCreatives" class="proposed-creatives-block col-lg-4 col-md-4 col-sm-6 col-xs-12"
                               :id="creative.id" :title="creative.title" :briefDescription="creative.briefDescription"
                               :imageUrl="creative.imageUrl" :eventDate="creative.eventDate" :price="creative.price"
                               :online="creative.online" :advertiserImageUrl="creative.advertiserImageUrl">
            </content-component>
        </div>
    </div>
</template>

<script>

    import contentComponent from "../content-component";

    export default {
        name: "proposed-creatives-component",
        props: ["id"],
        components: {
            contentComponent
        },
        data() {
            return {
                proposedDemoCreatives: []
            };
        },
        methods: {
            fillProposedDemoCreatives() {
                const self = this;
                const COUNT_CREATIVES = 3;
                this.$http.get("http://localhost:8080/proposed_demo_creatives",
                    {
                        params:
                        {
                            creative_id: self.id,
                            count: COUNT_CREATIVES
                        }
                    })
                    .then(response => {
                        console.log(response);
                        response.body.forEach(creative => {
                            self.proposedDemoCreatives.push({
                                id : creative.id,
                                title : creative.title,
                                briefDescription : creative.brief_description,
                                imageUrl : creative.image_url,
                                advertiserImageUrl : creative.advertiser_image_url,
                                eventDate : creative.event_date,
                                price : creative.price,
                                online : creative.online
                            })
                        });
                    });
            }
        },
        created() {
            this.fillProposedDemoCreatives();
        }
    }

</script>

<style scoped>

    .proposed-creatives-title {
        margin: 30px 0 30px 0;
        font-family: 'Roboto', sans-serif;
        font-size: 27px;
    }

    @media (min-width: 768px) and (max-width: 991px) {

        .proposed-creatives-block:last-of-type {
            display: none;
        }

    }

    @media(max-width:767px) {

        .proposed-creatives-title {
            margin-top: 15px;
        }

    }

</style>