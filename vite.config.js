import { fileURLToPath } from "node:url";
import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import { quasar, transformAssetUrls } from "@quasar/vite-plugin";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel(["resources/js/app.js"]),
        vue({
            template: { transformAssetUrls },
        }),
        quasar({
            sassVariables: fileURLToPath(
                new URL("./resources/css/app.sass", import.meta.url)
            ),
        }),
    ],
});
