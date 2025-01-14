<template>
    <div class="login-page">
        <h1>소셜 로그인</h1>

        <!-- 구글 로그인 -->
        <div>
            <button v-if="!isLoggedIn.google" @click="googleLogin" class="google-button">
                <img src="@/assets/img/googlelogin.png" alt="Login with Google" class="google-button-img" />
            </button>
            <button v-if="isLoggedIn.google" @click="googleLogout" class="logout-button">Google Logout</button>
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
            <button v-if="isLoggedIn.kakao" @click="kakaoLogout" class="logout-button">Kakao Logout</button>
        </div>

        <!-- 네이버 로그인 -->
        <div>
            <!-- 기존 코드에서는 accessToken 변수로 네이버 로그인 상태를 확인하고, 버튼 표시를 제어하고 있었습니다. 그러나 수정된 코드에서는 isLoggedIn.naver라는 상태 변수를 사용 -->
            <!-- 기존 방식: 네이버 로그인 여부를 accessToken으로 직접 확인. accessToken은 네이버 로그인 상태를 나타내는 것이 아니라, 로그인 성공 후 발급된 토큰을 저장하는 용도입니다.-->
            <!-- 로그인 상태를 나타내는 변수(isLoggedIn.naver)와 토큰(accessToken)을 분리하여 역할을 명확히 구분. -->
            <div id="naverIdLogin" v-if="!isLoggedIn.naver"></div>
            <button v-if="isLoggedIn.naver" @click="naverLogout" class="logout-button">Naver Logout</button>
        </div>
    </div>
</template>

<script>
// import { ref } from 'vue';
import { googleSdkLoaded } from 'vue3-google-login';

export default {
    data() {
        return {
            isLoggedIn: {
                google: false,
                kakao: false,
                naver: false
            },
            naverLogin: null, // 네이버 로그인 객체
            naverAccessToken: null // 네이버 로그인 액세스 토큰
        };
    },
    mounted() {
        // 카카오 SDK 초기화
        if (!window.Kakao.isInitialized()) {
            window.Kakao.init('12ecc1a13dbe01f4abcde8e95d9657af');
        }

        // 네이버 로그인 버튼 초기화
        this.initializeNaverLoginButton();
    },
    methods: {
        /** 구글 로그인 */
        googleLogin() {
            if (this.isLoggedIn.kakao || this.isLoggedIn.naver) {
                alert('다른 계정으로 이미 로그인되어 있습니다. 먼저 로그아웃하세요.');
                return;
            }
            googleSdkLoaded((google) => {
                google.accounts.oauth2
                    .initCodeClient({
                        client_id: process.env.VUE_APP_OAUTH_CLIENT,
                        scope: 'email profile openid',
                        callback: (response) => {
                            console.log('Google Login Response:', response);
                            this.isLoggedIn.google = true;
                        }
                    })
                    .requestCode();
            });
        },
        googleLogout() {
            console.log('Google Logout');
            this.isLoggedIn.google = false;
        },

        /** 카카오 로그인 */
        kakaoLogin() {
            if (this.isLoggedIn.google || this.isLoggedIn.naver) {
                alert('다른 계정으로 이미 로그인되어 있습니다. 먼저 로그아웃하세요.');
                return;
            }
            window.Kakao.Auth.login({
                scope: 'profile_image, profile_nickname',
                success: this.getKakaoAccount
            });
        },
        getKakaoAccount() {
            window.Kakao.API.request({
                url: '/v2/user/me',
                success: (res) => {
                    console.log('Kakao Login Response:', res);
                    this.isLoggedIn.kakao = true;
                },
                fail: (error) => {
                    alert('카카오 로그인 실패');
                    console.error(error);
                }
            });
        },
        kakaoLogout() {
            window.Kakao.Auth.logout(() => {
                console.log('Kakao Logout');
                this.isLoggedIn.kakao = false;
            });
        },

        /** 네이버 로그인 */
        initializeNaverLoginButton() {
            if (this.isLoggedIn.google || this.isLoggedIn.kakao) {
                alert('다른 계정으로 이미 로그인되어 있습니다. 먼저 로그아웃하세요.');
                return;
            }
            this.naverLogin = new window.naver.LoginWithNaverId({
                clientId: 'VumMcLkVDfXDMqskUBYa',
                callbackUrl: 'http://nede.dothome.co.kr/easylogin',
                isPopup: false,
                loginButton: { color: 'green', type: 3, height: 60 }
            });
            this.naverLogin.init(); // 네이버 SDK 초기화

            // 로그인 상태 확인
            this.naverLogin.getLoginStatus((status) => {
                if (status) {
                    this.checkNaverLoginStatus();
                }
            });
        },
        checkNaverLoginStatus() {
            // 네이버 로그인 상태 확인
            this.naverLogin.getLoginStatus((status) => {
                if (status) {
                    // 로그인 성공 시 사용자 정보 및 상태 업데이트
                    this.naverAccessToken = this.naverLogin.accessToken.accessToken;
                    console.log('Naver Login Success:', this.naverLogin.user); // 사용자 정보 출력 (디버깅용)
                    this.isLoggedIn.naver = true;
                } else {
                    console.log('Naver Login Failed');
                }
            });
        },
        naverLogout() {
            if (!this.naverAccessToken) {
                console.log('로그인 상태가 아닙니다.');
                return;
            }
            // 네이버 로그아웃 URL
            const logoutUrl = `https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id=VumMcLkVDfXDMqskUBYa&client_secret=k2DOtHw9Yf&access_token=${this.naverAccessToken}&service_provider=NAVER`;

            // iframe을 사용하여 로그아웃 요청
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = logoutUrl;
            document.body.appendChild(iframe);

            // 로그아웃 처리 후 상태 초기화
            this.naverAccessToken = null;
            this.isLoggedIn.naver = false;

            // DOM 업데이트 후 로그인 버튼 재초기화
            this.$nextTick(() => {
                this.initializeNaverLoginButton();
            });
            console.log('네이버 로그아웃 완료');
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
