import { Map, } from 'immutable'

export const InitialState = Map({
	popular: Map({
		fetching: false,
		data: Map({}),
	}),
	rides: Map({
		fetching: false,
		data: Map({}),
		active_ride: ''
	}),
	citys:
    [{
        value: 0,
        key : 0,
        text : 'Бүгд' 
    },
       {  
        value: 1,
        key : 1,
  		  text : 'Улаанбаатар' 
  	}, {
  		value: 2,
      key : 2,
  		text : 'Дархан' 
  	}, {
  	    value: 3,
        key : 3,
  		  text : 'Эрдэнэт' 
  	}, {
        value: 4,
        key : 4,
        text: 'Архангай',
    }, {
  		value: 5,
      key : 5,
  		text : 'Баянхонгор' 
  	}, {
      	value: 6,
        key : 6,
        text: 'Баян-Өлгий',
    }, {
      	value: 7,
        key : 7,
        text: 'Булган',
    }, {
      	value: 8,
        key : 8,
        text: 'Говь-Алтай',
    }, {
      	value: 9,
        key : 9,
        text: 'Говь-Сүмбэр',
    }, {
      	value: 10,
        key : 10,
        text: 'Дорнод',
    }, {
      	value: 11,
        key : 11,
        text: 'Дундговь',
    }, {
      	value: 12,
        key : 12,
        text: 'Дорноговь',
    }, {
      	value: 13,
        key : 13,
        text: 'Завхан',
    }, {
       	value: 14,
        key : 14,
        text: 'Өвөрхангай',
    },  {
      	value: 15,
        key : 15,
        text: 'Өмнөговь',
    }, {
      	value: 16,
        key : 16,
        text: 'Сэлэнгэ',
    }, {
      	value: 17,
        key : 17,
        text: 'Сүхбаатар',
    }, {
      	value: 18,
        key : 18,
        text: 'Төв',
    }, {
      	value: 19,
        key : 19,
        text: 'Увс',
    }, {
      	value: 20,
        key : 20,
        text: 'Ховд',
    }, {
      	value: 21,
        key : 21,
        text: 'Хөвсгөл',
    }, {
      	value: 22,
        key : 22,
        text: 'Хэнтий',
    }
  ]
})