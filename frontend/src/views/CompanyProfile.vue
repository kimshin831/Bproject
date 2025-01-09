<template>
    <div class="container">
        <TopButton title="회사 정보" />

        <div class="map-container">
            <div id="map"></div>
        </div>
        <div class="company">
            <p>주소: 서울특별시 중구 예시 주소</p>
            <p>대표번호: 02-1234-5678</p>
            <p>대표자: 홍길동</p>
            <p>휴대폰 번호: 010-1234-5678</p>
            <p>이메일: example@company.com</p>
        </div>
    </div>
</template>
<script>
import { onMounted } from 'vue';
import TopButton from '@/components/TopButton.vue';
export default {
    name: 'CompanyProfile',
    components: { TopButton },
    setup() {
        onMounted(() => {
            // 카카오맵 스크립트 로드
            const script = document.createElement('script');
            script.src = `https://dapi.kakao.com/v2/maps/sdk.js?appkey=c9c204b182c8f81f46c49322fed61963&autoload=false`;
            script.onload = () => {
                window.kakao.maps.load(() => {
                    // 지도 초기화
                    const container = document.getElementById('map'); // 지도를 표시할 div
                    const options = {
                        center: new kakao.maps.LatLng(37.5070431, 126.8902185), // 초기 중심 좌표 (서울시청)
                        level: 4 // 확대 레벨
                    };
                    const map = new kakao.maps.Map(container, options);

                    // 마커 생성
                    const markerPosition = new kakao.maps.LatLng(37.5070431, 126.8902185); // 마커 위치
                    const marker = new kakao.maps.Marker({
                        position: markerPosition
                    });
                    marker.setMap(map);

                    // 마커 정보 창
                    const infowindow = new kakao.maps.InfoWindow({
                        content: '<div class="marker">회사 위치</div>' // 정보 창 내용
                    });
                    infowindow.open(map, marker);
                });
            };
            document.head.appendChild(script);
        });
    }
};
</script>
<style>
.map-container {
    width: 100%;
    margin: 0 auto;
    padding: 10px 0;
}
#map {
    width: 350px;
    height: 280px;
    margin: 0 auto;
    background: #999;
}
.marker {
    padding: 5px;
    width: 150px;
    text-align: center;
    font-weight: 600;
}
</style>
