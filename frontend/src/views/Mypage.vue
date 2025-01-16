<template>
    <div class="container">
        <TopButton title="마이페이지" />
        <div class="profile">
            <img src="@/assets/img/user.svg" alt="user" />
            <div class="title">
                <!-- 로그인 상태에 따라 메시지 변경 -->
                <template v-if="isLoggedIn"> {{ userName }}님 환영합니다. </template>
                <template v-else> 야생동물을 구해주세요. </template>
            </div>
            <!-- 로그인 상태에 따라 버튼 변경 -->
            <a class="login" @click="toggleLogin">
                {{ isLoggedIn ? '로그아웃 >' : '로그인 >' }}
            </a>
        </div>
        <div class="stats">
            <div>
                <a class="link point">
                    포인트
                    <strong>0P</strong>
                </a>
            </div>
            <div>
                <a class="link coupon">
                    쿠폰
                    <strong>0장</strong>
                </a>
            </div>
            <div>
                <a class="link order">
                    주문내역
                    <strong>0</strong>
                </a>
            </div>
            <div>
                <a class="link delivery">
                    배송
                    <strong>0</strong>
                </a>
            </div>
            <div>
                <a class="link evaluation">
                    나의 평가
                    <strong>0</strong>
                </a>
            </div>
            <div>
                <a class="link inquiry">
                    문의
                    <strong>0</strong>
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
                        <p>{{ weather.temp }}º</p>
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
            isLoggedIn: false, // 로그인 상태 여부
            userName: '' // 로그인한 사용자 이름
        };
    },
    methods: {
        Login() {
            this.$router.push('/login');
        },
        async toggleLogin() {
            if (this.isLoggedIn) {
                // 로그아웃 요청
                try {
                    const response = await fetch('/api/auth/logout.php', {
                        method: 'POST',
                        credentials: 'include' // 쿠키 포함
                    });
                    const data = await response.json();
                    console.log('Logout Response:', data); // 디버깅용

                    if (data.status === 'success') {
                        this.isLoggedIn = false;
                        this.userName = '';
                        alert('로그아웃되었습니다.');
                    } else {
                        alert(data.message || '로그아웃 실패');
                    }
                } catch (error) {
                    console.error('로그아웃 요청 중 오류:', error);
                    alert('로그아웃 요청 중 오류 발생');
                }
            } else {
                // 로그인 페이지로 이동
                this.$router.push('/login');
            }
        },
        async checkLoginStatus() {
            try {
                const response = await fetch('/api/auth/check_login.php', {
                    method: 'GET',
                    credentials: 'include' // 쿠키 포함
                });
                console.log('Response Status:', response.status); // 디버깅용
                const data = await response.json();
                console.log('Response Data:', data); // 디버깅용

                // 로그인 상태 확인 (데이터를 logged_in으로 판단)
                if (data.logged_in) {
                    this.isLoggedIn = true;
                    this.userName = data.username;
                } else {
                    console.log('로그인되지 않음:', data);
                    this.isLoggedIn = false;
                    this.userName = '';
                }
            } catch (error) {
                console.error('로그인 상태 확인 중 오류:', error);
            }
        }
    },
    mounted() {
        // 초기 로그인 상태 확인
        this.checkLoginStatus();
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
    margin-top: 25px;
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
    float: left;
    margin-top: 13px;
    font-size: 1.3rem;
    font-weight: bold;
    color: #555;
    line-height: 30px;
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
    margin-top: 130px;
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
