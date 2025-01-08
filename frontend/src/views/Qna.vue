<template>
    <div class="header">
        <TopButton title="Q&A" />
    </div>
    <div class="title">
        <h1>무엇을<br />도와드릴까요?</h1>
    </div>
    <div class="search">
        <form class="d-flex" role="search">
            <button class="btn btn-outline-success" type="submit">Search</button>
            <input class="form-control me-2" type="search" placeholder="검색어를 입력해주세요!" aria-label="Search" />
        </form>
    </div>
    <div class="container">
        <ul>
            <li>1:1 문의</li>
            <li>취소/반품</li>
            <li>날씨</li>
            <li>배송문의</li>
            <li>상품문의</li>
            <li>찾아오시는길</li>
        </ul>
    </div>
    <div class="question">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseOne"
                        aria-expanded="false"
                        aria-controls="collapseOne"
                    >
                        <span>01</span>&ensp; 반품은 언제까지 가능한가요? 비용이 따로 드나요?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        반품은 상품을 수령하신 날짜를 기준으로 15일 이내에 가능합니다. 다만 상품의 불량, 배송 오류 등
                        당사의 실수로 인한 반품인 경우, 30일 이내 신청이 가능합니다.<br />또한, 반품 시 지불하셔야 하는
                        반품비용은 회수비 2,500원입니다. 단, 매장반품의 경우 별도 회수비용 없이 반품가능합니다. ※
                        추가비용이 발생하는 경우 - 도서산간: +2,500원 (5,000원) - 제주도: +2,500원 (5,000원) - 제주도의
                        도서산간 지역: +7,000원 (9,500원) - 무료배송이었으나 부분적인 반품으로 인해 무료배송
                        조건(결제금액 2만원 이상)이 깨진 경우 : 면제받으셨던 초기 배송비 2,500원 추가 발생 * 오늘드림
                        배송 옵션 별 상이 발생 ※ 반품비는 환불금액에서 차감처리 됩니다. ※ 업체배송 상품의 경우 업체의
                        규정에 따라 비용이 상이할 수 있습니다. ※ 상품의 불량, 배송 오류 등 당사의 실수로 인한 반품의
                        경우, 반품에 필요한 비용은 당사가 부담합니다.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo"
                        aria-expanded="false"
                        aria-controls="collapseTwo"
                    >
                        <span>02</span>&ensp; 주문을 잘못해서 취소하고 싶어요..
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        입금 전 고객님께서 직접 취소가 가능 하십니다. 주문내역 -> 주문상세보기에서 주문서를 확인하시고
                        주문서 제일 하단에 주문 취소를 클릭하셔서 주문취소 하실 수 있습니다. 입금 후 입금 후
                        상품준비중인 상태에서는 주문내역 -> 주문서 상세보기에서 주문서를 확인하시고 주문서 제일 하단에
                        선택상품 취소를 클릭하셔서 주문취소 하실 수 있습니다. 상품준비상태 이후로는 고객님께서 직접
                        취소가 어렵기 때문에 고객센터 02-888-8888 또는 1:1 문의 게시판으로 취소 요청을 해주시면 주문서
                        취소해드리고 환불 받으실수 있습니다.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseThree"
                        aria-expanded="false"
                        aria-controls="collapseThree"
                    >
                        <span>03</span>&ensp; 배송조회는 어떻게 하나요?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        배송조회는 [마이페이지 > 주문내역]에서 배송조회 할 상품을 클릭하여 확인이 가능합니다.
                        '배송조회'는 배송이 시작되어 "배송중"상태가 되면 노출되며, "결제완료" 또는
                        "상품준비중","배송준비중" 상태에서는 확인하실 수 없습니다.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseFour"
                        aria-expanded="false"
                        aria-controls="collapseFour"
                    >
                        <span>04</span>&ensp;상품을 구매하고 싶은데 '구매하기' 버튼이 없어요.<br />&ensp;어떻게
                        구매가능한가요?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        NEDE에 등록괸 화장품은 기본적으로 성분 및 리뷰 확인이 가능한 '제품'이며, 이 중 NEDE 쇼핑을 통해
                        구매가 가능한 제품에만 '장바구니' 또는 '바로구매'버튼이 존재합니다. 따라서 화장품 정보가
                        제공되는 모든 제품을 구매가 가능한 것은 아니며,NEDE를 통해 구매가 가능한제품은 아래와 같이 확인
                        가능합니다.<br />
                        - 제품 정보 페이지 하단의 '장바구니' 또는 '바로구매'버튼이 노출됩니다<br />
                        '장바구니' 또는 '바로구매' 버튼이 없는 제품인 경우, NEDE에 입고 되지않아 구매가 불가한
                        제품이오니 이점 참고하여 양해부탁드립니다.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="margin"></div>
</template>
<script>
import TopButton from '@/components/TopButton.vue';

export default {
    name: 'Qna',
    components: {
        TopButton
    }
};
</script>

<style scoped>
.title {
    margin: 40px 0px 30px 0px;
}

.title h1 {
    width: 90%;
    margin: 0 auto;
    text-align: left;
    font-size: 35px;
    font-weight: bold;
}

.search {
    width: 90%;
    margin: 0 auto;
    position: relative;
}

.btn.btn-outline-success {
    position: absolute;
    top: 10px;
    left: 5px;
    width: 25px;
    height: 25px;
    background: url(@/assets/img/search.svg) no-repeat;
    text-indent: -9999px;
    z-index: 50;
    border: none;
}

.form-control {
    border: none;
    padding-left: 30px;
    text-align: left;
    border-radius: 0px;
    border-bottom: 1px solid #000;
}

.container {
    width: 100%;
    background-color: #f1f1f1;
    margin-top: 30px;
    margin-bottom: 30px;
}

.container ul {
    list-style: none;
    width: 100%;
    height: 160px;
    padding: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.container ul li {
    float: left;
    width: 32%;
    height: 68px;
    margin: 5px 0;
    background-color: #fff;
    text-align: center;
    line-height: 68px;
    font-size: 15px;
    font-weight: 700;
}

.accordion-header span {
    font-size: 18px;
    font-weight: 700;
    margin-right: 5px;
}

.accordion-header button {
    font-size: 13px;
    line-height: 21px;
    font-weight: 700;
}

.accordion-body {
    font-size: 12.5px;
    line-height: 24px;
}

.accordion-button::after {
    content: '';
    background: url(@/assets/img/stat.png);
    width: 20px;
    height: 20px;
}

.accordion-button:not(.collapsed)::after {
    content: '';
    background: url(@/assets/img/stat.png);
    width: 20px;
    height: 20px;
}

.margin {
    height: 67px;
}
</style>
