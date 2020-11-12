/*
 * Copyright 2018 Vladimir Balun
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

"use strict";

import Vue from "vue";
import VueRouter from "vue-router";

import mainPage from "../pages/main-page";
import creativePage from "../pages/creative-page";
import signupPage from "../pages/signup-page";
import loginPage from "../pages/login-page";
import advertiserRoomPage from "../pages/advertiser-room-page";

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: "/",
            component: mainPage
        },
        {
            path: "/creative/:id",
            component: creativePage
        },
        {
            path: "/signup",
            component: signupPage
        },
        {
            path: "/login",
            component: loginPage
        },
        {
            path: "/advertiser_room",
            component: advertiserRoomPage
        }
    ]
});

export default router;