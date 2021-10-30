<template>
    <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
        Ссылка с помощью атрибута href
    </a>
    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
        Кнопка с атрибутом data-bs-target
    </button>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Вне холста</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                Какой-то текст в качестве заполнителя. В реальной жизни у вас могут быть элементы, которые Вы выбрали. Нравится, текст, изображения, списки и т. д.
            </div>
            <div class="dropdown mt-3">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                    Кнопка раскрывающегося списка
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#">Действие</a></li>
                    <li><a class="dropdown-item" href="#">Другое действие</a></li>
                    <li><a class="dropdown-item" href="#">Что-то еще здесь</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "rightPanel-component"
}
</script>

<style scoped>
#side-checkbox {
    display: none;
}
.side-panel {
    position: fixed;
    z-index: 999999;
    top: 0;
    left: -360px;
    background: #337AB7;
    transition: all 0.5s;
    width: 320px;
    height: 100vh;
    box-shadow: 10px 0 20px rgba(0,0,0,0.4);
    color: #FFF;
    padding: 40px 20px;
}
.side-title {
    font-size: 20px;
    padding-bottom: 10px;
    margin-bottom: 20px;
    border-bottom: 2px solid #BFE2FF;
}
/* Оформление кнопки на странице */
.side-button-1-wr {
    text-align: center; /* Контейнер для кнопки, чтобы было удобнее ее разместить */
}
.side-button-1 {
    display: inline-block;
}
.side-button-1 .side-b {
    margin: 10px;
    text-decoration: none;
    position: relative;
    font-size: 20px;
    line-height: 20px;
    padding: 12px 30px;
    color: #FFF;
    font-weight: bold;
    text-transform: uppercase;
    font-family: 'Roboto Condensed', Тahoma, sans-serif;
    background: #337AB7;
    cursor: pointer;
    border: 2px solid #BFE2FF;
}
.side-button-1 .side-b:hover,
.side-button-1 .side-b:active,
.side-button-1 .side-b:focus {
    color: #FFF;
}
.side-button-1 .side-b:after,
.side-button-1 .side-b:before {
    position: absolute;
    height: 4px;
    left: 50%;
    bottom: -6px;
    content: "";
    transition: all 280ms ease-in-out;
    width: 0;
}
.side-button-1 .side-open:after,
.side-button-1 .side-open:before {
    background: green;
}
.side-button-1 .side-close:after,
.side-button-1 .side-close:before {
    background: red;
}
.side-button-1 .side-b:before {
    top: -6px;
}
.side-button-1 .side-b:hover:after,
.side-button-1 .side-b:hover:before {
    width: 100%;
    left: 0;
}
/* Переключатели кнопки 1 */
.side-button-1 .side-close {
    display: none;
}
#side-checkbox:checked + .side-panel + .side-button-1-wr .side-button-1 .side-open {
    display: none;
}
#side-checkbox:checked + .side-panel + .side-button-1-wr .side-button-1 .side-close {
    display: block;
}
#side-checkbox:checked + .side-panel {
    left: 0;
}
/* Оформление кнопки на панеле */
.side-button-2 {
    font-size: 30px;
    border-radius: 20px;
    position: absolute;
    z-index: 1;
    top: 8px;
    right: 8px;
    cursor: pointer;
    transform: rotate(45deg);
    color: #BFE2FF;
    transition: all 280ms ease-in-out;
}
.side-button-2:hover {
    transform: rotate(45deg) scale(1.1);
    color: #FFF;
}


</style>
