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
import adminRoomPage from "../pages/admin-room-page"

import * as network from "./network";

Vue.use(VueRouter);

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) {
        return parts.pop().split(';').shift();
    }
}

const router = new VueRouter({
    routes: [
        {
            path: "/",
            component: mainPage
        },
        {
            path: "/creative-page/:id",
            component: creativePage
        },
        {
            path: "/signup",
            component: signupPage,
            beforeEnter: (to, from, next) => {
                if ((document.cookie.indexOf("trainster_id=") !== -1) || (document.cookie.indexOf("trainster_hash=") !== -1)) {
                    network.identifyAdvertiser(response => {
                        console.log(response.result);
                        if (response.result) {
                            next("/admin_room/" + getCookie("trainster_id"));
                        } else {
                            next();
                        }
                    }, error => {
                        console.log(error);
                        next();
                    });
                } else {
                    next();
                }
            }
        },
        {
            path: "/login",
            component: loginPage,
            beforeEnter: (to, from, next) => {
                if ((document.cookie.indexOf("trainster_id=") !== -1) || (document.cookie.indexOf("trainster_hash=") !== -1)) {
                    network.identifyAdvertiser(response => {
                        console.log(response.result);
                        if (response.result) {
                            next("/admin_room/" + getCookie("trainster_id"));
                        } else {
                            next();
                        }
                    }, error => {
                        console.log(error);
                        next();
                    });
                } else {
                    next();
                }
            }
        },
        {
            path: "/admin_room/:id",
            component: adminRoomPage,
            beforeEnter: (to, from, next) => {
                if ((document.cookie.indexOf("trainster_id=") === -1) || (document.cookie.indexOf("trainster_hash=") === -1)) {
                    next("/signup");
                } else {
                    next();
                }
            }
        }
    ]
});

export default router;