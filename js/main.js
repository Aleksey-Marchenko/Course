// modal footer
var modal = document.querySelector('.modal');
var body = document.querySelector('.body-wrapper');
var popap = document.querySelector('.callback-modal__body');


function openModal() {
	modal.style.display = 'block';
}

function closeModal() {
	modal.style.display = 'none';
}

var openButton = document.querySelector('.footer__button');
openButton.addEventListener('click', openModal);

var closeButton = document.querySelector('.close');
closeButton.addEventListener('click', closeModal);

document.addEventListener('click', (e) => {
	const withinBoundaries4 = e.composedPath().includes(popap);
	const withinBoundaries5 = e.composedPath().includes(body);
	if (!withinBoundaries4 && !withinBoundaries5) {
		modal.style.display = 'none'; // скрываем элемент т к клик был за его пределами
	}
})

console.log(popap)

// modal main
var modal1 = document.querySelector('.modal-1');
var body1 = document.querySelector('.body-wrapper');
var popap1 = document.querySelector('.main-modal__body');


function openModal1() {
	modal1.style.display = 'block';
}

function closeModal1() {
	modal1.style.display = 'none';
}

var openButton1 = document.querySelector('.header__button');
openButton1.addEventListener('click', openModal1);

var closeButton1 = document.querySelector('.close-1');
closeButton1.addEventListener('click', closeModal1);

document.addEventListener('click', (e) => {
	const withinBoundaries = e.composedPath().includes(popap1);
	const withinBoundaries1 = e.composedPath().includes(body1);
	if (!withinBoundaries && !withinBoundaries1) {
		modal1.style.display = 'none'; // скрываем элемент т к клик был за его пределами
	}
})
// modal offer
var modal2 = document.querySelector('.modal-2');
var body2 = document.querySelector('.body-wrapper');
var popap2 = document.querySelector('.main-modal__body2');


function openModal2() {
	modal2.style.display = 'block';
}

function closeModal2() {
	modal2.style.display = 'none';
}

var openButton2 = document.querySelector('.section-1__btn');
openButton2.addEventListener('click', openModal2);

var closeButton2 = document.querySelector('.close-2');
closeButton2.addEventListener('click', closeModal2);

document.addEventListener('click', (e) => {
	const withinBoundaries2 = e.composedPath().includes(popap2);
	const withinBoundaries3 = e.composedPath().includes(body2);
	if (!withinBoundaries2 && !withinBoundaries3) {
		modal2.style.display = 'none'; // скрываем элемент т к клик был за его пределами
	}
})



// slider block
const buttons = document.querySelectorAll('.item');
const slides = document.querySelectorAll('.slide');

function showSlide(index) {
	slides.forEach(slide => {
		slide.style.display = 'none';
	});
	slides[index].style.display = 'flex';
}

buttons.forEach((button, index) => {
	button.addEventListener('click', () => {
		showSlide(index);
	});
});

const items = document.querySelectorAll('.item');

function toggleActiveClass(event) {
	items.forEach(item => item.classList.remove('active'));

	event.target.classList.add('active');
}

items.forEach(item => item.addEventListener('click', toggleActiveClass));

items[0].classList.add('active');

document.addEventListener("DOMContentLoaded", function () {
	var eventCalllback = function (e) {
		var el = e.target,
			clearVal = el.dataset.phoneClear,
			pattern = el.dataset.phonePattern,
			matrix_def = "+7(___) ___-__-__",
			matrix = pattern ? pattern : matrix_def,
			i = 0,
			def = matrix.replace(/\D/g, ""),
			val = e.target.value.replace(/\D/g, "");
		if (clearVal !== 'false' && e.type === 'blur') {
			if (val.length < matrix.match(/([\_\d])/g).length) {
				e.target.value = '';
				return;
			}
		}
		if (def.length >= val.length) val = def;
		e.target.value = matrix.replace(/./g, function (a) {
			return /[_\d]/.test(a) && i < val.length ? val.charAt(i++) : i >= val.length ? "" : a
		});
	}
	var phone_inputs = document.querySelectorAll('input[type="tel"]');
	for (let elem of phone_inputs) {
		for (let ev of ['input', 'blur', 'focus']) {
			elem.addEventListener(ev, eventCalllback);
		}
	}
}); ы