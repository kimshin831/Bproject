<template>
    <div class="login-page">
        <h1>간편 로그인</h1>

        <!-- 구글 로그인 -->
        <div>
            <button v-if="!isLoggedIn.google" @click="googleLogin" class="google-button">
                <img src="@/assets/img/googlelogin.png" alt="Login with Google" class="google-button-img" />
            </button>
        </div>

        <!-- 카카오 로그인 -->
        <div>
            <a id="kakao-login-btn" v-if="!isLoggedIn.kakao" @click="kakaoLogin">
                <img
                    src="https://k.kakaocdn.net/14/dn/btroDszwNrM/I6efHub1SN5KCJqLm1Ovx1/o.jpg"
                    width="222"
                    alt="카카오 로그인 버튼"
                />
            </a>
        </div>

        <!-- 네이버 로그인 -->
        <div>
            <div id="naverIdLogin" v-if="!isLoggedIn.naver"></div>
        </div>
    </div>
</template>

<script>
import { googleSdkLoaded } from 'vue3-google-login';

export default {
    data() {
        return {
            isLoggedIn: {
                google: false,
                kakao: false,
                naver: false
            },
            naverAccessToken: null // 네이버 액세스 토큰 저장
        };
    },
    mounted() {
        this.updateIsLoggedIn(); // 초기화
        this.initializeKakao();
        this.initializeNaverLoginButton();
    },
    methods: {
        /**
         * LocalStorage를 기반으로 로그인 상태 업데이트
         */
        updateIsLoggedIn() {
            this.isLoggedIn = {
                google: localStorage.getItem('googleLoggedIn') === 'true',
                kakao: localStorage.getItem('kakaoLoggedIn') === 'true',
                naver: localStorage.getItem('naverLoggedIn') === 'true'
            };
            console.log('Updated isLoggedIn:', this.isLoggedIn);
        },

        /**
         * 카카오 SDK 초기화
         */
        initializeKakao() {
            if (!window.Kakao.isInitialized()) {
                window.Kakao.init('b65d155bd8d1bfb900dca929ae8afabc');
            }
        },

        /**
         * 네이버 로그인 버튼 초기화
         */
        initializeNaverLoginButton() {
            const naverButton = document.getElementById('naverIdLogin');
            if (!naverButton) {
                console.error('Naver login button not found.');
                return;
            }

            const naverLogin = new window.naver.LoginWithNaverId({
                clientId: 'MyEYpin_VSCD218l6SHu',
                callbackUrl: 'http://green609b.dothome.co.kr/easylogin',
                isPopup: false,
                loginButton: { color: 'green', type: 3, height: 60 }
            });
            naverLogin.init();

            naverButton.onclick = () => {
                if (this.checkIfLoggedIn()) {
                    naverLogin.login();
                }
            };

            naverLogin.getLoginStatus((status) => {
                if (status) {
                    this.naverAccessToken = naverLogin.accessToken.accessToken;
                    localStorage.setItem('naverLoggedIn', 'true');
                    this.updateIsLoggedIn();
                    this.$router.push('/mypage');
                }
            });
        },

        /**
         * 다른 소셜 계정 로그인이 활성화되어 있는지 확인
         */
        checkIfLoggedIn() {
            if (Object.values(this.isLoggedIn).some((status) => status)) {
                const confirmLogout = confirm('다른 계정으로 로그인되어 있습니다. 로그아웃하시겠습니까?');
                if (confirmLogout) {
                    this.logoutAll();
                    return true;
                } else {
                    return false;
                }
            }
            return true;
        },

        /**
         * 모든 소셜 계정 로그아웃 처리
         */
        logoutAll() {
            console.log('Logging out from all services...');
            this.googleLogout();
            this.kakaoLogout();
            this.naverLogout();

            // 상태 초기화
            this.isLoggedIn = { google: false, kakao: false, naver: false };
            localStorage.clear();
            console.log('All login states cleared.');
        },

        /**
         * 구글 로그인
         */
        googleLogin() {
            if (!this.checkIfLoggedIn()) return;
            googleSdkLoaded((google) => {
                google.accounts.oauth2
                    .initCodeClient({
                        client_id: process.env.VUE_APP_OAUTH_CLIENT,
                        scope: 'email profile openid',
                        callback: (response) => {
                            console.log('Google Login Response:', response);
                            localStorage.setItem('googleLoggedIn', 'true');
                            this.updateIsLoggedIn();
                            this.$router.push('/mypage');
                        }
                    })
                    .requestCode();
            });
        },

        /**
         * 구글 로그아웃
         */
        googleLogout() {
            console.log('Google Logout');
            const googleLogoutUrl = 'https://accounts.google.com/Logout';
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = googleLogoutUrl;
            document.body.appendChild(iframe);

            setTimeout(() => {
                this.isLoggedIn.google = false;
                localStorage.removeItem('googleLoggedIn');
                console.log('Google logout complete.');
            }, 500);
        },

        /**
         * 카카오 로그인
         */
        kakaoLogin() {
            if (!this.checkIfLoggedIn()) return;
            window.Kakao.Auth.login({
                scope: 'profile_image, profile_nickname',
                success: this.getKakaoAccount,
                fail: (error) => {
                    alert('카카오 로그인 실패');
                    console.error(error);
                }
            });
        },

        getKakaoAccount() {
            window.Kakao.API.request({
                url: '/v2/user/me',
                success: (res) => {
                    console.log('Kakao Login Response:', res);
                    localStorage.setItem('kakaoLoggedIn', 'true');
                    this.updateIsLoggedIn();
                    this.$router.push('/mypage');
                },
                fail: (error) => {
                    alert('카카오 로그인 실패');
                    console.error(error);
                }
            });
        },

        /**
         * 카카오 로그아웃
         */
        kakaoLogout() {
            if (window.Kakao.Auth) {
                window.Kakao.Auth.logout(() => {
                    localStorage.removeItem('kakaoLoggedIn');
                    this.updateIsLoggedIn();
                    console.log('Kakao logout complete.');
                });
            }
        },

        /**
         * 네이버 로그아웃
         */
        naverLogout() {
            if (!this.naverAccessToken) return;

            const logoutUrl = `https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id=MyEYpin_VSCD218l6SHu&client_secret=kkCdziVPyr&access_token=${this.naverAccessToken}&service_provider=NAVER`;
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = logoutUrl;
            document.body.appendChild(iframe);

            setTimeout(() => {
                this.naverAccessToken = null;
                localStorage.removeItem('naverLoggedIn');
                this.updateIsLoggedIn();
                console.log('Naver logout complete.');
            }, 500);
        }
    }
};
</script>

<style scoped>
.login-page {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.google-button,
.logout-button {
    padding: 10px 20px;
    background-color: #4285f4;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

.google-button:hover,
.logout-button:hover {
    background-color: #357ae8;
}
</style>
