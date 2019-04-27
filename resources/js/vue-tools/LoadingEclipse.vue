<!--CC0 license from loading.io-->
<template>

    <div class="d-flex justify-content-center text-center">

        <div class="justify-content-center lds-css ng-scope" style="display: flex;">
            <div style="width:100%;height:100%" class=" lds-eclipse"><div></div></div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "loading-eclipse"
    }
</script>

<style scoped>

    @keyframes lds-eclipse {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        50% {
            -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @-webkit-keyframes lds-eclipse {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        50% {
            -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    .lds-eclipse {
        position: relative;
    }
    .lds-eclipse div {
        position: absolute;
        -webkit-animation: lds-eclipse 1.7s linear infinite;
        animation: lds-eclipse 1.7s linear infinite;
        width: 60px;
        height: 60px;
        top: 70px;
        left: 70px;
        border-radius: 50%;
        box-shadow: 0 4px 0 0 #93dbe9;
        -webkit-transform-origin: 30px 32px;
        transform-origin: 30px 32px;
    }
    .lds-eclipse {
        width: 200px !important;
        height: 200px !important;
        -webkit-transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
        transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
    }
</style>