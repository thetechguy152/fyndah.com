<template>
    <div class="projecthome mb-2">
        <div class="half-circle-spinner" v-if="isLoading">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
        </div>
        <div v-if="show_empty_string && ! isLoading && ! data.length" class="col-12 text-center">
            <span>{{ __('No property found') }}!</span>
        </div>
        <h5 class="headifhouse" v-if="title && ! isLoading && data.length">{{ title }}</h5>
        <div class="row rowm10">
            <template v-for="item in data">
                <div class="col-sm-6 col-lg-4 col-xl-3 colm10" v-html="item.HTML" :key="item.id" v-favorites="item.id"
                     v-if="!isLoading && data.length">
                </div>
            </template>
        </div>
    </div>
</template>

<script>

export default {

    data: function () {
        return {
            isLoading: true,
            data: [],
            wishListCookies: [],
        };
    },

    mounted() {
        this.parseCookie();
        this.getProperties();
    },

    props: {
        title: {
            type: String,
            default: () => '',
        },
        url: {
            type: String,
            default: () => null,
            required: true
        },
        type: {
            type: String,
            default: () => 'rent',
        },
        limit: {
            type: Number,
            default: () => null,
        },
        property_id: {
            type: Number,
            default: () => null,
        },
        project_id: {
            type: Number,
            default: () => null,
        },
        show_empty_string: {
            type: Boolean,
            default: () => false
        },
    },

    methods: {
        parseCookie() {
            let getCookie = function (cname) {
                let name = cname + '=';
                let ca = document.cookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) === ' ') {
                        c = c.substring(1);
                    }

                    if (c.indexOf(name) === 0) {
                        return c.substring(name.length, c.length);
                    }
                }

                return '';
            }

            let cookieName = window.currentLanguage + '_wishlist';
            let wishListCookies = decodeURIComponent(getCookie(cookieName));

            if (wishListCookies != null && !!wishListCookies) {
                this.wishListCookies = JSON.parse(wishListCookies);
            }
        },
        getProperties() {
            this.data = [];
            this.isLoading = true;
            let url = this.url + '?type=' + this.type;

            if (this.property_id) {
                url += '&property_id=' + this.property_id;
            }

            if (this.project_id) {
                url += '&project_id=' + this.project_id;
            }

            if (this.limit) {
                url += '&limit=' + this.limit;
            }

            axios.get(url)
                .then(res => {
                    this.data = res.data.data ? res.data.data : [];
                    this.isLoading = false;
                });
        },
    },
    directives: {
        favorites: {
            bind: function (el, binding, vnode) {
                let wishListCookies = vnode.context.wishListCookies;
                if (wishListCookies && wishListCookies.length) {
                    let exists = wishListCookies.some(el => el.id === binding.value);
                    if (exists) {
                        el.querySelector('.add-to-wishlist i').classList.add('fas');
                    }
                }
            }
        }
    }
}
</script>
