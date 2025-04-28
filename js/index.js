function onEntry(entry) {
    entry.forEach(change => {
      if (change.isIntersecting) {
       change.target.classList.add('active');
      }
      // else{
      //   change.target.classList.remove('active');
      // }
    });
  }

  let options = {
    threshold: [0.5] };
  let observer = new IntersectionObserver(onEntry, options);
  let element1 = document.querySelectorAll('.go');

  // let arr = [element1, element2, element3, element4, element5, 
  //   element6, element7, element8, element9, element10, element11, element12, element13, element14];

    for (let elm of element1) {
      observer.observe(elm);
    }




    
    // Найти все ссылки начинающиеся на #
const anchors = document.querySelectorAll('a[href^="#"]')

// Цикл по всем ссылкам
for(let anchor of anchors) {
  anchor.addEventListener("click", function(e) {
    e.preventDefault() // Предотвратить стандартное поведение ссылок
    // Атрибут href у ссылки, если его нет то перейти к body (наверх не плавно)
    const goto = anchor.hasAttribute('href') ? anchor.getAttribute('href') : 'body'
    // Плавная прокрутка до элемента с id = href у ссылки
    document.querySelector(goto).scrollIntoView({
      behavior: "smooth",
      block: "start"
    })
  })
}
    