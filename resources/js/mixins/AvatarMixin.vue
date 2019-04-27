<script>
    export default {
        name: "AvatarMixin",
        methods: {
            generateAvatarCdn(size="50", identifier){
                return "https://api.adorable.io/avatars/" + String(size)+ "/" + String(identifier) + ".png"
            }
        },
    }
</script>

