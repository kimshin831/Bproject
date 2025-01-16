<template>
    <div class="container">
        <TopButton title="마이페이지" />
        <div class="profile">
            <div class="userIcon">
                <img src="@/assets/img/user.svg" alt="user" />
            </div>
            <div class="title">
                <!-- 로그인 상태에 따라 메시지 변경 -->
                <template v-if="Object.values(isLoggedIn).some((v) => v)"> {{ userName }}님 환영합니다. </template>
                <template v-else> 야생동물을 구해주세요. </template>
            </div>
            <!-- 로그인 상태에 따라 버튼 변경 -->
            <div>
                <a class="login" v-if="Object.values(isLoggedIn).some((v) => v)" @click="toggleLogin"> 로그아웃 > </a>
                <a class="login" v-else @click="Login"> 로그인 > </a>
            </div>
        </div>
        <div class="stats">
            <div>
                <a class="link point">
                    <strong>0P</strong>
                    포인트
                </a>
            </div>
            <div>
                <a class="link coupon">
                    <strong>0장</strong>
                    쿠폰
                </a>
            </div>
            <div>
                <a class="link order">
                    <strong>0</strong>
                    주문내역
                </a>
            </div>
            <div>
                <a class="link delivery">
                    <strong>0</strong>
                    배송
                </a>
            </div>
            <div>
                <a class="link evaluation">
                    <strong>0</strong>
                    나의 평가
                </a>
            </div>
            <div>
                <a class="link inquiry">
                    <strong>0</strong>
                    문의
                </a>
            </div>
        </div>
        <div class="section">
            <ul class="event">
                이벤트
                <li>이벤트 신청 / 당첨내역</li>
                <li>이벤트 배송지 수정</li>
            </ul>
            <ul class="service">
                고객센터
                <li>제품등록 요청</li>
                <li>요청등록 제품</li>
                <li>Q & A</li>
                <li>1:1 문의</li>
                <li>설정</li>
            </ul>
        </div>
        <div class="weather">날씨</div>
        <div class="weather-container">
            <div class="weatherBox" v-if="weather && weatherIcon">
                <div class="weatherBox-lt">
                    <div><img :src="weatherIcon" :alt="weatherIcon" /></div>
                    <div>
                        <p>{{ weather.temp }}</p>
                    </div>
                </div>
                <div class="weatherBox-rt">
                    <p>
                        최고ㅣ{{ weather.temp_max }} ℃ <br />
                        최저ㅣ{{ weather.temp_min }} ℃
                    </p>
                    <p>
                        미세먼지 <span :style="{ color: airConditionColor }">{{ airCondition }}</span>
                    </p>
                </div>
            </div>
            <div class="weatherBox" v-else>
                <p>날씨 정보 불러오는 중...</p>
            </div>
        </div>
    </div>
</template>
<script>
import TopButton from '@/components/TopButton.vue';
import { ref, onMounted } from 'vue';

export default {
    name: 'Mypage',
    components: {
        TopButton
    },
    data() {
        return {
            isLoggedIn: {
                google: false,
                kakao: false,
                naver: false,
                general: false
            },
            userName: '', // 로그인한 사용자 이름
            naverAccessToken: null // 네이버 액세스 토큰 저장
        };
    },
    mounted() {
        console.log('Mounted: Checking initial login state...');
        this.updateIsLoggedIn(); // LocalStorage 기반 초기화
        this.checkNaverLogin(); // 네이버 로그인 상태 확인
        this.checkLoginStatus(); // 서버 기반 로그인 상태 확인
        console.log('Initial isLoggedIn:', this.isLoggedIn); // 상태 로그 확인

        // UI 강제 업데이트
        setTimeout(() => {
            this.$forceUpdate(); // UI 동기화
            console.log('Final isLoggedIn after timeout:', JSON.stringify(this.isLoggedIn));
        }, 500);
    },

    methods: {
        Login() {
            this.$router.push('/login');
        },

        updateIsLoggedIn() {
            this.isLoggedIn = {
                google: localStorage.getItem('googleLoggedIn') === 'true',
                kakao: localStorage.getItem('kakaoLoggedIn') === 'true',
                naver: localStorage.getItem('naverLoggedIn') === 'true',
                general: localStorage.getItem('isLoggedIn') === 'true' // 일반 로그인 상태 추가
            };
            console.log('Updated isLoggedIn:', JSON.stringify(this.isLoggedIn));
        },
        async logoutAll() {
            console.log('소셜 및 일반 로그아웃 시작...');

            await Promise.all([this.googleLogout(), this.kakaoLogout(), this.naverLogout()]);

            try {
                console.log('PHP 로그아웃 요청...');
                const response = await fetch('/api/auth/logout.php', {
                    method: 'POST',
                    credentials: 'include' // 세션 쿠키 포함
                });
                const data = await response.json();
                console.log('PHP Logout Response:', data);

                if (data.status !== 'success') {
                    throw new Error(data.message || 'PHP 로그아웃 실패');
                }
            } catch (error) {
                console.error('PHP 로그아웃 요청 중 오류:', error);
                alert('로그아웃 처리 중 오류가 발생했습니다.');
            } finally {
                this.isLoggedIn = { google: false, kakao: false, naver: false, general: false };
                this.userName = '';
                localStorage.clear();
                console.log('모든 상태 초기화 완료.');
            }
        },

        googleLogout() {
            return new Promise((resolve) => {
                console.log('Logging out from Google...');
                const googleLogoutUrl = 'https://accounts.google.com/Logout';
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = googleLogoutUrl;
                document.body.appendChild(iframe);

                setTimeout(() => {
                    this.isLoggedIn.google = false;
                    localStorage.removeItem('googleLoggedIn');
                    console.log('Google logout complete.');
                    resolve();
                }, 500);
            });
        },

        kakaoLogout() {
            return new Promise((resolve) => {
                console.log('Logging out from Kakao...');
                if (window.Kakao && window.Kakao.Auth) {
                    window.Kakao.Auth.logout(() => {
                        this.isLoggedIn.kakao = false;
                        localStorage.removeItem('kakaoLoggedIn');
                        console.log('Kakao logout complete.');
                        resolve();
                    });
                } else {
                    console.error('Kakao SDK가 로드되지 않았습니다.');
                    resolve();
                }
            });
        },

        naverLogout() {
            return new Promise((resolve) => {
                console.log('Logging out from Naver...');
                if (!this.naverAccessToken) {
                    console.log('Naver is not logged in.');
                    resolve();
                    return;
                }
                const logoutUrl = `https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id=MyEYpin_VSCD218l6SHu&client_secret=kkCdziVPyr&access_token=${this.naverAccessToken}&service_provider=NAVER`;
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = logoutUrl;
                document.body.appendChild(iframe);

                setTimeout(() => {
                    this.naverAccessToken = null;
                    this.isLoggedIn.naver = false;
                    localStorage.removeItem('naverLoggedIn');
                    console.log('Naver logout complete.');
                    resolve();
                }, 500);
            });
        },

        async toggleLogin() {
            if (Object.values(this.isLoggedIn).some((v) => v)) {
                // 로그인 상태일 때만 로그아웃 처리
                console.log('로그아웃 진행 중...');

                try {
                    await this.logoutAll(); // 모든 로그아웃 작업 실행
                    alert('로그아웃되었습니다.');

                    // 로그아웃 완료 후 상태 초기화
                    this.isLoggedIn = { google: false, kakao: false, naver: false };
                    this.userName = '';
                    localStorage.clear();
                } catch (error) {
                    console.error('로그아웃 중 문제가 발생했습니다:', error);
                    alert('로그아웃 처리 중 오류가 발생했습니다.');
                }
            } else {
                // 이미 로그아웃 상태인 경우
                alert('이미 로그아웃 상태입니다.');
                this.$router.push('/login');
            }
        },

        async checkLoginStatus() {
            try {
                const response = await fetch('/api/auth/check_login.php', {
                    method: 'GET',
                    credentials: 'include' // 세션 쿠키 포함
                });

                if (!response.ok) {
                    throw new Error(`Failed to check login status: ${response.status}`);
                }

                const data = await response.json();

                if (data.logged_in) {
                    this.isLoggedIn.general = true;
                    this.userName = data.username;
                    localStorage.setItem('isLoggedIn', 'true');
                } else {
                    this.isLoggedIn.general = false;
                    localStorage.removeItem('isLoggedIn');
                }
            } catch (error) {
                console.error('로그인 상태 확인 중 오류:', error);
                this.isLoggedIn.general = false;
            } finally {
                this.updateIsLoggedIn(); // UI 동기화
            }
        },

        checkNaverLogin() {
            const naverLogin = new window.naver.LoginWithNaverId({
                clientId: 'MyEYpin_VSCD218l6SHu',
                callbackUrl: 'http://green609b.dothome.co.kr/easylogin',
                isPopup: false
            });
            naverLogin.getLoginStatus((status) => {
                if (status) {
                    this.naverAccessToken = naverLogin.accessToken.accessToken;
                    localStorage.setItem('naverLoggedIn', 'true');
                    this.updateIsLoggedIn();
                } else {
                    console.log('No Naver login detected.');
                }
            });
        }
    },
    setup() {
        // 반응형 데이터 선언
        const weather = ref(null); // 날씨 데이터를 저장할 객체
        const weatherIcon = ref(''); // 날씨 아이콘 URL
        const airCondition = ref(''); // 미세먼지 상태
        const airConditionColor = ref(''); // 미세먼지 상태에 따른 텍스트 색상

        /* 날씨 가져오기 함수 */
        const fetchWeatherData = async () => {
            try {
                const weatherResponse = await fetch(
                    'https://api.openweathermap.org/data/2.5/weather?lat=37.2992437&lon=126.9782357&appid=822e1d81a695655b411c939d26499c1f&units=Metric'
                );
                const weatherData = await weatherResponse.json(); // 응답 데이터를 JSON으로 변환
                // 날씨 데이터를 'weather'에 저장
                weather.value = {
                    temp: weatherData.main.temp, // 현재 온도
                    temp_min: weatherData.main.temp_min, // 최저 온도
                    temp_max: weatherData.main.temp_max // 최고 온도
                };

                // 날씨 아이콘을 가져오기위한 코드
                const iconCode = weatherData.weather[0].icon;
                weatherIcon.value = `https://openweathermap.org/img/wn/${iconCode}@2x.png`;
            } catch (error) {
                console.error('날씨 데이터를 가져오는 중 오류 발생: ', error);
            }
        };

        /* 미세먼지 데이터 가져오는 함수 */
        const fetchAirQualityData = async () => {
            try {
                const airResponse = await fetch(
                    'http://api.openweathermap.org/data/2.5/air_pollution?lat=37.5070431&lon=126.8902185&appid=822e1d81a695655b411c939d26499c1f'
                );
                const airData = await airResponse.json();

                const fineDust = airData.list[0].components.pm2_5;

                if (fineDust <= 15) {
                    airCondition.value = '좋음';
                    airConditionColor.value = '#0085FF';
                } else if (fineDust > 16 && fineDust <= 35) {
                    airCondition.value = '보통';
                    airConditionColor.value = '#009806';
                } else if (fineDust > 36 && fineDust <= 75) {
                    airCondition.value = '나쁨';
                    airConditionColor.value = '#FF2B1E';
                } else {
                    airCondition.value = '매우 나쁨';
                    airConditionColor.value = '#B90B00';
                }
            } catch (error) {
                console.error('공기 오염 데이터를 가져오는 중 오류발생: ', error);
            }
        };
        // 컴포넌트가 마운트될 때 두 api호출
        onMounted(() => {
            // 날씨 데이터 가져오기
            fetchWeatherData();
            // 미세먼지 데이터 가져오기
            fetchAirQualityData();
        });

        // 반응형 데이터 반환
        return {
            weather,
            weatherIcon,
            airCondition,
            airConditionColor
        };
    }
};
</script>
<style scoped>
.container {
    text-align: center;
}

.profile {
    height: 100px;
    margin-top: 37px;
    line-height: 2rem;
}

.profile img {
    width: 85px;
    height: 85px;
    float: left;
    object-fit: contain;
    padding-top: 11px;
    border-radius: 50%;
    border: 1px solid #000;
    margin: 0 15px 0 10px;
}

.profile .title {
    margin-top: 13px;
    font-size: 1.3rem;
    font-weight: bold;
    color: #555;
    line-height: 30px;
    text-align: left;
}

.login {
    width: 60%;
    float: left;
    text-align: left;
    font-size: 1.1rem;
    text-decoration: none;
    color: #333;
    font-weight: bold;
    cursor: pointer;
}

.stats {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 3px;
    margin: 10px 0 20px 0;
}

.stats div {
    padding: 5px;
    font-size: 0.9rem;
}

.link {
    cursor: pointer;
    text-decoration: none;
    color: #000;
}

.stats div:nth-child(3n-1) {
    border-left: 1px solid #000;
    border-right: 1px solid #000;
}
.stats div:nth-child(-n + 3) {
    border-bottom: 1px solid #000;
}

.stats div strong {
    display: block;
    font-size: 20px;
    margin-bottom: 5px;
}

.section {
    width: 100%;
    text-align: left;
}

.section ul {
    list-style: none;
    font: 0.9rem;
    font-weight: 700;
    color: #777;
    line-height: 2rem;
    margin-bottom: 20px;
    letter-spacing: -0.07rem;
    padding-left: 20px;
}

.section ul li {
    font-size: 1.1rem;
    color: #000;
}

/* 날씨 */

.weather {
    font: 0.9rem;
    font-weight: 700;
    color: #777;
    line-height: 2rem;
    letter-spacing: -0.07rem;
    padding-left: 20px;
    text-align: left;
    margin-top: 30px;
}

.weather-container {
    width: 100%;
    height: 93px;
    margin: 0 auto;
}

.weatherBox-lt div {
    display: block;
    float: left;
}

.weatherBox-lt img {
    float: left;
    width: 60px;
    margin-left: 10px;
}

.weatherBox-lt p {
    font-size: 1.3rem;
    line-height: 60px;
    font-weight: 700;
}

.weatherBox-rt {
    float: right;
    margin: 7px 10px;
}

.weatherBox-rt p {
    float: left;
    font-size: 0.9rem;
    text-align: left;
    font-weight: 600;
    margin-left: 7px;
}
</style>
