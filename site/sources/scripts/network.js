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

import $ from "jquery";
import MD5 from "crypto-js/md5";

const testScriptAddress = "http://mysite.local/trening/application/src/";
const prodScriptAddress = "http://trainter.ru/platform/application/src/";
const scriptAddress = testScriptAddress;

function getServerAddress() {
    if (process.env.PRODUCTION_MODE) {
        return "";
    } else if (process.env.DEVELOPMENT_MODE) {
        return "http://mysite.local/trening/application/src/";
    } else {
        throw "Unknown environment mode. You need to use PRODUCTION_MODE or DEVELOPMENT_MODE";
    }
}

export const identifyAdvertiser = (onSuccessLoadClb, onFailedLoadClb) => {
    $.get(scriptAddress + "api/authorization/identify.php", response => {
        onSuccessLoadClb(JSON.parse(response));
    }).fail(error => {
        onFailedLoadClb(JSON.parse(error));
    });
};

export const signupAdvertiser = (vueResource, advertiser, onSuccessLoadClb, onFailedLoadClb) => {
    advertiser.username = advertiser.username.trim();
    advertiser.email = advertiser.email.trim();
    advertiser.password = MD5(advertiser.password.trim()).toString();
    vueResource.$http.post(scriptAddress + "api/authorization/signup.php", advertiser, { emulateJSON: true })
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
};

export const loginAdvertiser = (vueResource, advertiser, onSuccessLoadClb, onFailedLoadClb) => {
    advertiser.email = advertiser.email.trim();
    advertiser.password = MD5(advertiser.password.trim()).toString();
    vueResource.$http.post(scriptAddress + "api/authorization/login.php", advertiser, { emulateJSON: true })
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
};

export const logoutAdvertiser = (vueResource,onSuccessLoadClb, onFailedLoadClb) => {
    vueResource.$http.post(scriptAddress + "api/authorization/logout.php")
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
};

export const loadDemoCreativesWithFilters = (vueResource, filters, onSuccessLoadClb, onFailedLoadClb) => {
    loadDemoCreativesImpl(vueResource, '', filters, onSuccessLoadClb, onFailedLoadClb);
};

export const loadDemoCreativesWithTitlePattern = (vueResource, titlePattern, onSuccessLoadClb, onFailedLoadClb) => {
    loadDemoCreativesImpl(vueResource, titlePattern, {}, onSuccessLoadClb, onFailedLoadClb);
};

export const loadDemoCreatives = (vueResource, onSuccessLoadClb, onFailedLoadClb) => {
    loadDemoCreativesImpl(vueResource, '', {}, onSuccessLoadClb, onFailedLoadClb);
};

function loadDemoCreativesImpl(vueResource, titlePattern, filters, onSuccessLoadClb, onFailedLoadClb) {
    vueResource.$http.get(scriptAddress + "api/creatives/get_demo_creatives.php", { params: { title_pattern: titlePattern, filters }})
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
}

export const loadAdvertiserDemoCreatives = (vueResource, advertiserId, onSuccessLoadClb, onFailedLoadClb) => {
    vueResource.$http.get(scriptAddress + "api/creatives/get_advertiser_demo_creatives_by_id.php", { params: { advertiser_id: advertiserId }})
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
};

export const loadProposedDemoCreatives = (vueResource, creativeId, count, onSuccessLoadClb, onFailedLoadClb) => {
    vueResource.$http.get(scriptAddress + "api/creatives/get_proposed_demo_creatives.php", { params: { creative_id: creativeId, count: count }})
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
};

export const loadCreativeById = (vueResource, creativeId, onSuccessLoadClb, onFailedLoadClb) => {
    vueResource.$http.get(scriptAddress + "api/creatives/get_creative_by_id.php", { params: { creative_id: creativeId } })
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
};

export const loadMetaInformation = (vueResource, onSuccessLoadClb, onFailedLoadClb) => {
    vueResource.$http.get(scriptAddress + "api/meta/get_meta.php")
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
};

export const loadCitiesByCountryName = (vueResource, countryName, onSuccessLoadClb, onFailedLoadClb) => {
    vueResource.$http.get(scriptAddress + "api/meta/get_cities_by_country_name.php", { params: { country_name: countryName } })
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
};

export const removeCreativeById = (vueResource, creativeId, onSuccessLoadClb, onFailedLoadClb) => {
    vueResource.$http.put(scriptAddress + "api/creatives/delete_creative_by_id.php", {creative_id: parseInt(creativeId)}, { emulateJSON: true })
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
};

export const addCreativeByAdvertiserId = (vueResource, advertiserId, creative, onSuccessLoadClb, onFailedLoadClb) => {
    correctCreativeForResponse(creative);
    creative.advertiser_id = advertiserId;
    vueResource.$http.post(scriptAddress + "api/creatives/add_creative.php", creative, { emulateJSON: true })
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
}

export const changeCreative = (vueResource, creative, onSuccessLoadClb, onFailedLoadClb) => {
    correctCreativeForResponse(creative);
    vueResource.$http.put(scriptAddress + "api/creatives/change_creative.php", creative, { emulateJSON: true })
        .then(response => {
            console.log(response);
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
}

function correctCreativeForResponse(creative) {
    console.log(creative.eventDate);
    if (creative.country === "Не выбрано") {
        creative.country = null
    }
    if (creative.city === "Не выбрано") {
        creative.city = null;
    }
    if (creative.eventDate === "") {
        creative.eventDate = null;
    }
    if (creative.email === "") {
        creative.email = null;
    }
    if (creative.number === "") {
        creative.number = null;
    }
    if (creative.site === "") {
        creative.site = null;
    }
}

export const changeAdvertiserImageUrlById = (vueResource, advertiserId, newAdvertiserImageUrl, onSuccessLoadClb, onFailedLoadClb) => {
    const request = {};
    request.advertiser_id = advertiserId;
    request.new_image_url = newAdvertiserImageUrl;
    vueResource.$http.put(scriptAddress + "api/advertisers/change_advertiser_image_by_id.php", request, { emulateJSON: true })
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
};