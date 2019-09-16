<template>
    <div class="wrapper" >

        <nav id="sidebar" :class="{'active': value}">
        <!--<nav id="sidebar">-->
            <!-- Close Sidebar Button -->
            <!--<div id="dismiss" @click="dismiss">-->
                <!--<i class="far fa-times-circle"></i>-->
            <!--</div>-->

            <!-- Sidebar Header -->
            <div class="sidebar-header">
                <h3 style="color: #1e3eb9">
                    <slot name="header"></slot>
                </h3>
            </div>

            <div class="sidebar-content">
                <slot name="content"></slot>
            </div>

        </nav>


        <transition name="fade">
            <div v-if="value" @click="dismiss" class="overlay"></div>
        </transition>


    </div>

</template>

<script>

    export default {
        name: "collapsible-sidebar",
        data(){
            return {
                // showSidebarMutable: false,
            }
        },

        props:{
            value: {
                type: Boolean,
            },

        },

        computed:{
            // showSidebarComputed: {
            //     get() {
            //         // this.showSidebarMutable = this.showSidebar;
            //         return this.showSidebar;
            //     },
            //     // set(value) {
            //     //     this.showSidebarMutable = value;
            //     // }
            // }
        },

        methods: {
            dismiss(){
                // this.showSidebarMutable = false;
                this.$emit('dismiss-sidebar');
                this.$emit('input', false)
            }

        }
    }

</script>

<style scoped>

    /*
    DEMO STYLE
*/
    @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";


    body {
        font-family: 'Poppins', sans-serif;
        background: #FFFFFF;
    }

    p {
        font-family: 'Poppins', sans-serif;
        font-size: 1.1em;
        font-weight: 300;
        line-height: 1.7em;
        color: #999;
    }

    a, a:hover, a:focus {
        color: inherit;
        text-decoration: none;
        transition: all 0.3s;
    }

    .navbar {
        padding: 15px 10px;
        background: #fff;
        border: none;
        border-radius: 0;
        margin-bottom: 40px;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
    }

    .navbar-btn {
        box-shadow: none;
        outline: none !important;
        border: none;
    }

    .line {
        width: 100%;
        height: 1px;
        border-bottom: 1px dashed #686868;
        margin: 40px 0;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }

    .wrapper{
        display: block;
    }

    /* ---------------------------------------------------
        SIDEBAR STYLE
    ----------------------------------------------------- */
    #sidebar {
        width: 80%;
        position: fixed;
        top: 0;
        right: -100%;
        height: 100vh;
        z-index: 1050;
        background: #e3e4e5;
        color: #383838;
        transition: all 0.3s;
        overflow-y: scroll;
        box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.2);
    }

    #sidebar.active {
        right: 0;
    }

    #dismiss {
        width: 35px;
        height: 35px;
        line-height: 35px;
        text-align: center;
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
    }
    #dismiss:hover {
        background: #fff;
        color: #a6a6a6;
    }

    #dismiss .fa-times-circle {
        width: 35px;
        height: 35px;
        color: #000;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1049;
        /*display: none;*/
    }

    #sidebar .sidebar-header {
        padding: 20px;
        background: #a6a7a8;
    }

    #sidebar ul.components {
        padding: 20px 0;
        border-bottom: 1px solid #47748b;
    }

    #sidebar ul p {
        color: #030303;
        padding: 10px;
    }

    #sidebar ul li a {
        padding: 10px;
        font-size: 1.1em;
        display: block;
    }
    #sidebar ul li a:hover {
        color: #9bc2d1;
        background: #FFFFFF;
    }

    #sidebar ul li.active > a, a[aria-expanded="true"] {
        color: #afd8ff;
        background: #ffffff;
    }


    a[data-toggle="collapse"] {
        position: relative;
    }

    a[aria-expanded="false"]::before, a[aria-expanded="true"]::before {
        content: '\e259';
        display: block;
        position: absolute;
        right: 20px;
        font-family: 'Glyphicons Halflings';
        font-size: 0.6em;
    }
    a[aria-expanded="true"]::before {
        content: '\e260';
    }


    ul ul a {
        font-size: 0.9em !important;
        padding-left: 30px !important;
        background: #6d7fcc;
    }

    ul.CTAs {
        padding: 20px;
    }

    ul.CTAs a {
        text-align: center;
        font-size: 0.9em !important;
        display: block;
        border-radius: 5px;
        margin-bottom: 5px;
    }
    a.download {
        background: #fff;
        color: #7386D5;
    }
    a.article, a.article:hover {
        background: #6d7fcc !important;
        color: #fff !important;
    }


    /* ---------------------------------------------------
        CONTENT STYLE
    ----------------------------------------------------- */
    #content {
        width: 100%;
        padding: 20px;
        min-height: 100vh;
        transition: all 0.3s;
        position: absolute;
        top: 0;
        right: 0;
    }


</style>
