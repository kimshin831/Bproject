const { defineConfig } = require('@vue/cli-service');
module.exports = defineConfig({
    transpileDependencies: true,
    lintOnSave: false,
    devServer: {
        // 개발서버 설정
        proxy: {
            '/oauth2.0': {
                target: 'https://nid.naver.com',
                changeOrigin: true,
                pathRewrite: { '^/oauth2.0': '/oauth2.0' }
            }
        },
        client: {
            // 클라이언트 측 오버레이 설정
            overlay: false
        }
    }
});
