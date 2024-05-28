function searchTable() {
    // Получаем значение из поля ввода поиска
    var input = document.getElementById("searchInput");
    var filter = input.value.toUpperCase();
    
    // Получаем таблицу и строки в таблице
    var table = document.getElementById("productTable");
    var tr = table.getElementsByTagName("tr");
    
    // Перебираем все строки таблицы и скрываем те, которые не соответствуют поисковому запросу
    for (var i = 0; i < tr.length; i++) {
        var td = tr[i].getElementsByTagName("td");
        var found = false;
        for (var j = 0; j < td.length; j++) {
            var txtValue = td[j].textContent || td[j].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        if (found) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}

// Функция для открытия модального окна
function openModal(modalId) {
    var modal = document.getElementById(modalId + 'Modal');
    if (modal) {
        modal.style.display = "block";
    }
}

// Функция для закрытия модального окна
function closeModal(modalId) {
    var modal = document.getElementById(modalId + 'Modal');
    if (modal) {
        modal.style.display = "none";
    }
}

// Закрываем модальные окна, если пользователь щелкает вне окна
window.onclick = function(event) {
    var modals = document.getElementsByClassName('modal');
    for (var i = 0; i < modals.length; i++) {
        var modal = modals[i];
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

