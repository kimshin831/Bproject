<template>
    <div>
        <button type="button" @click="goBack" class="back">
            <img src="../assets/img/chevron-left-solid.svg" alt="뒤로가기" width="20" height="20" />
        </button>
    </div>
    <div class="logo">
        <img src="../assets/img/nede_3.jpg" alt="logo" width="200" height="75" />
    </div>
    <div class="login">
        <form action="">
            <div class="id"><input type="text" placeholder="아이디" required /></div>
            <div class="pass"><input type="password" placeholder="비밀번호" required /></div>
        </form>
    </div>
    <div class="find">
        <a href="#">아이디 찾기</a>&emsp;
        <a href="#">비밀번호 찾기</a>
    </div>
    <div class="login">
        <button type="button">로그인</button>
    </div>
    <div class="easylogin">
        <ul>
            <li>
                <a id="kakao-login-btn" @click="kakaoLogin" v-if="!isLoggedIn">
                    <img src="../assets/img/kakaologin.png" alt="kakao" width="50" height="50" />
                </a>
            </li>
            <li>
                <a id="naverIdLogin" v-if="!accessToken">
                    <img src="../assets/img/naverlogin.png" alt="kakao" width="50" height="50" />
                </a>
            </li>
            <li>
                <a class="google-button" @click="login" v-if="!LoggedIn">
                    <img
                        src="../assets/img/googlelogin.png"
                        class="google-button-img"
                        alt="kakao"
                        width="50"
                        height="50"
                    />
                </a>
            </li>
        </ul>
        <button class="logoutbutton kakaobutton" type="button" v-if="isLoggedIn" @click="kakaoLogout">로그아웃</button>
        <button class="logoutbutton" type="button" v-if="accessToken" @click="logout">로그아웃</button>
        <button class="logoutbutton" type="button" v-if="LoggedIn" @click="googlelogout">로그아웃</button>
    </div>
    <div class="membership">
        <a href="#">회원가입</a>
    </div>
    <div class="non-member">
        <a href="#">비회원 로그인</a>
    </div>
</template>
<script>
import axios from 'axios';
import { ref } from 'vue';
import { googleSdkLoaded } from 'vue3-google-login';

export default {
    comment: {},
    data() {
        return {
            code: '', // 현재 필요 없음, 카카오 인증 코드를 저장하는 변수
            isLoggedIn: false, // 로그인 상태 초기화
            naverLogin: null, // 네이버 로그인 객체
            accessToken: null // 네이버 로그인 후 발급받은 엑세스 토큰
        };
    },
    mounted() {
        // 3bd79f7e9158fd56823269331562c024
        if (!window.Kakao.isInitialized()) {
            // 초기화 되지 않은 경우, 앱키를 사용해 sdk초기화
            window.Kakao.init('3bd79f7e9158fd56823269331562c024');
        }
        this.initializeNaverLoginButton();
    },
    methods: {
        /* 카카오 로그인 메서드 */
        kakaoLogin() {
            window.Kakao.Auth.login({
                scope: 'profile_nickname,profile_image', // 요청할 권한 (프로필이미지, 닉네임)
                success: this.getKakaoAccount // 로그인 성공 시 호출할 메서드
            });
        },
        /* 로그인 성공 후 사용자 정보를 가져옴. */
        getKakaoAccount() {
            window.Kakao.API.request({
                url: '/v2/user/me', // 사용자 정보 요청url
                success: (res) => {
                    const kakao_account = res.kakao_account; // 사용자 계정 정보
                    const profile = kakao_account.profile_image; // 카카오 프로필
                    const nickname = kakao_account.profile_nickname; // 카카오 프로필
                    // 콘솔에서 로그인 정보 확인
                    console.log('profile', profile);
                    console.log('nickname', nickname);

                    // 로그인 처리
                    console.log(kakao_account);

                    this.isLoggedIn = true; // 로그인 성공시 상태
                    alert('로그인 성공!');
                },
                fail: (error) => {
                    // 사용자 정보 요청 실패시
                    alert('로그인에 실패했습니다. 다시 시도해주세요');
                    console.log(error);
                }
            });
        },
        /* 카카오 로그아웃 메서드 */
        kakaoLogout() {
            if (!window.Kakao.Auth.getAccessToken) {
                // 엑세스 토큰이 없는 경우(로그아웃상태)
                console.log('로그인 되지 않았습니다.');
                return;
            }
            // 로그아웃 처리
            window.Kakao.Auth.logout((response) => {
                console.log('access token:', window.Kakao.Auth.getAccessToken());
                console.log('log out:', response); // 로그아웃 응답 출력
                this.isLoggedIn = false; // 로그아웃 상태
            });
        },
        initializeNaverLoginButton() {
            try {
                // 네이버 로그인 객체 생성
                this.naverLogin = new window.naver.LoginWithNaverId({
                    clientId: 'ZV5ixXEmu_gZ4yxrRoGX',
                    callbackUrl: 'http://localhost:8080/login',
                    isPopup: false,
                    loginButton: { color: 'green', type: 1, height: 50 } // 로그인 버튼 스타일
                });
                // 네이버 로그인 SDK 초기화
                this.naverLogin.init();

                // SDK 초기화 후 로그인 상태 확인
                this.naverLogin.getLoginStatus((status) => {
                    if (status) {
                        // 로그인 상태인 경우 로그인 상태 확인 메서드 호출
                        this.checkLoginStatus();
                    } else {
                        console.log('로그인 되지 않은 상태입니다.');
                    }
                });
            } catch (error) {
                // 초기화 중 오류 발생시 에러메세지 출력
                console.error('네이버 로그인 초기화 중 오류 발생:', error);
            }
        },
        /* 로그인 상태 확인 및 사용자 정보 가져오기 */
        checkLoginStatus() {
            if (!this.naverLogin) {
                console.error('네이버 로그인 객체가 초기화되지 않았습니다.');
                return;
            }
            // 로그인 상태 확인
            this.naverLogin.getLoginStatus((status) => {
                if (status) {
                    // 로그인 상태인 경우 사용자 정보 가져오기
                    const email = this.naverLogin.user.getEmail();
                    if (!email) {
                        alert('이메일은 필수 정보입니다. 정보 제공을 동의해주세요.');
                        this.naverLogin.reprompt(); // 동의 요청 팝업 다시 표시
                    }
                    // 엑세스 토큰 저장
                    this.accessToken = this.naverLogin.accessToken.accessToken;
                    console.log('로그인 성공!', email);
                } else {
                    console.log('callback 처리에 실패하였습니다.');
                }
            });
        },
        /* 로그아웃 메서드 */
        logout() {
            if (!this.accessToken) {
                console.log('로그인 상태가 아닙니다.');
                return;
            }

            // 네이버 로그아웃 URL 생성
            const logoutUrl = `https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id=ZV5ixXEmu_gZ4yxrRoGX&client_secret=1vsmi8sEes&access_token=${this.accessToken}&service_provider=NAVER`;

            // iframe 생성 및 URL 호출
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none'; // 사용자에게 보이지 않도록 숨김
            iframe.src = logoutUrl;
            document.body.appendChild(iframe);

            // 액세스 토큰 초기화
            this.accessToken = null;

            // DOM 업데이트 후 로그인 버튼 초기화
            this.$nextTick(() => {
                this.initializeNaverLoginButton();
            });

            console.log('로그아웃 요청이 실행되었습니다.');
        },
        goBack() {
            this.$router.go(-1); // 뒤로가기
        }
    }
};
</script>
<script setup>
const oauthClientId = process.env.VUE_APP_OAUTH_CLIENT;

const LoggedIn = ref(false); // 초기 로그아웃 상태

/* 구글 로그인 처리 */
const login = () => {
    /* 클라이언트 초기화 */
    googleSdkLoaded((google) => {
        google.accounts.oauth2
            .initCodeClient({
                client_id: '518440475104-aul8mgjiufstam3m06hhtsvnlpis8r2u.apps.googleusercontent.com',
                scope: 'email profile openid',
                callback: (response) => {
                    console.log('응답을 처리합니다.', response);
                    LoggedIn.value = true;
                }
            })
            .requestCode(); // 인증코드를 요청
    });
};

/* 로그아웃 처리 */
const googlelogout = () => {
    console.log('로그아웃');
    LoggedIn.value = false;
};
</script>
<style scoped>
.back {
    position: absolute;
    left: 10px;
    top: 10px;
}

.logo {
    margin: 150px 0 80px 0;
}

.login {
    width: 80%;
    margin: 0 auto;
}

input[type='text'],
input[type='password'] {
    width: 93%;
    padding: 10px;
    border: 1px solid #246012;
    border-radius: 4px;
    margin-top: 10px;
}

.find {
    margin-top: 10px;
}

.find a {
    text-decoration: none;
    color: #808080;
}

.login button {
    width: 92%;
    padding: 10px;
    background-color: #246012;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 20px;
}

.easylogin {
    width: 90%;
    margin-top: 0px;
}

.easylogin ul {
    list-style: none;
}

.easylogin ul li {
    float: left;
    margin-left: 45px;
}

.easylogin ul li:first-child {
    margin-left: 45px;
}

.easylogin img {
    cursor: pointer;
}

.membership {
    width: 75%;
    position: absolute;
    bottom: 170px;
    left: 50px;
    border: 1px solid #246012;
    border-radius: 3px;
    padding: 5px 0;
}

.membership a {
    text-decoration: none;
    color: #808080;
}

.non-member {
    width: 75%;
    position: absolute;
    bottom: 120px;
    left: 50px;
    border: 1px solid #246012;
    border-radius: 3px;
    padding: 5px 0;
}

.non-member a {
    text-decoration: none;
    color: #808080;
}

.logoutbutton {
    border: none;
    background-color: #246012;
    border-radius: 3px;
    color: #fff;
    padding: 5px 10px;
    margin-left: 40px;
    margin-top: 10px;
}

.kakaobutton {
    margin-left: -2rem;
}
</style>
