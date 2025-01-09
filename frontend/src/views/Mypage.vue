<template>
    <TopButton title="마이페이지" />
    <div class="container">
        <div class="profile">
            <img src="@/assets/img/profile.png" alt="?" />
            <div class="title">야생동물을 구해주세요.</div>
            <a class="login" @click="Login">로그인 &gt;</a>
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
                        <span>최고 : {{ weather.temp_max }} ℃ </span><span>최저: {{ weather.temp_min }} ℃</span>
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
    methods: {
        Login() {
            this.$router.push('/login');
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
                    'http://api.openweathermap.org/data/2.5/air_pollution?lat=37.5070431&lon=127.018956&appid=822e1d81a695655b411c939d26499c1f'
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
.link {
    cursor: pointer;
    text-decoration: none;
    color: #000;
}
.container {
    margin-top: 25px;
    text-align: center;
}

.profile {
    height: 100px;
    margin-bottom: 20px;
    line-height: 17px;
}

.profile img {
    width: 85px;
    height: 85px;
    float: left;
    object-fit: scale-down;
    border-radius: 50%;
    border: 1px solid #000;
    margin-right: 10px;
}

.profile .title {
    float: left;
    margin: 10px 0;
    font-size: 22px;
    font-weight: bold;
    color: #555;
    line-height: 30px;
}

.login {
    float: left;
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
    gap: 10px;
    margin: 30px 0;
}

.stats div {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    font-size: 14px;
    background: #f5f5f5;
}

.stats div strong {
    display: block;
    font-size: 20px;
    margin-bottom: 5px;
}
.weather-container {
    width: 100%;
    margin: 0 auto;
    padding: 10px 0;
}
/* 날씨 API */
.weatherBox {
    margin: 0 auto;
    width: 350px;
    height: 70px;
    background: #999;
    display: flex;
    justify-content: left;
}
.weatherBox-lt {
    display: flex;
}
.weatherBox-lt div {
    width: 70px;
    height: 100%;
}
.weatherBox-lt img {
    display: block;
    width: 70px;
    height: 70px;
}
.weatherBox-lt div p {
    font-size: 1.5em;
    line-height: 70px;
    font-weight: 700;
}
.weatherBox-rt p {
    font-size: 0.9em;
    margin: 0;
    font-weight: 600;
}
</style>
