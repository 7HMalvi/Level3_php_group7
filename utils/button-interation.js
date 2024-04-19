var buttons = document.getElementsByClassName('btn-primary');

for (var i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener('focus', function() {this.style.backgroundColor = 'red';
    });

    buttons[i].addEventListener('blur', function() {this.style.backgroundColor = '';
    });

    buttons[i].addEventListener('mouseover', function() {this.style.backgroundColor = 'red';
    });

    buttons[i].addEventListener('mouseout', function() 
    {
        if (!this.matches(':focus')) {this.style.backgroundColor = ''; 
        }
    });
}
