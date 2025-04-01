import Error from '../utils/Error';

class ValidaPratoForm {
    constructor() {
        this.formulario = document.querySelector('.prato-form');

        if(!this.formulario) return;

        this.init();
    }

    init() {
        this.formulario.addEventListener('submit', event => {
            this.handleSubmit(event);
        });
    }

    handleSubmit(event) {
        event.preventDefault();
        const camposValidos = this.isFieldValid();

        if(camposValidos) {
            this.formulario.submit();
        }
    }

    isFieldValid() {
        let valid = true;

        for(let errorText of this.formulario.querySelectorAll('.text-danger')) {
            errorText.remove();
        }

        for(let field of this.formulario.querySelectorAll('.validar')) {
            let label = field.previousElementSibling.innerHTML;

            if(!field.value) {
                Error.criaErro(field, `Campo "${label.replace(':', '').toLocaleLowerCase()}" não pode estar em branco.`);
                valid = false;
            } else {
                if(field.classList.contains('nome')) {
                    if(!this.isNomeValid(field)) valid = false;
                }

                if(field.classList.contains('descricao')) {
                    if(!this.isDescricaoValid(field)) valid = false;
                }

                if(field.classList.contains('categoria')) {
                    if(!this.isCategoriaValid(field)) valid = false;
                }

                if(field.classList.contains('imagem')) {
                    if(!this.isImagemValid(field)) valid = false;
                }
            }
        }

        return valid;
    }

    isNomeValid(field) {
        const pratoNome = field.value;
        let valid = true;

        if (pratoNome.length < 3 || pratoNome.length > 100) {
            Error.criaErro(field, 'Deve conter entre 3 a 100 caracteres');
            valid = false;
            return;
        }

        if(!/^[a-zA-Zà-úÀ-ÚçÇ\s\-,]+$/.test(pratoNome)) {
            Error.criaErro(field, 'Deve conter apenas letras');
            valid = false;
        }

        return valid;
    }

    isDescricaoValid(field) {
        const pratoDesc = field.value;
        let valid = true;

        if (pratoDesc.length < 3 || pratoDesc.length > 100) {
            Error.criaErro(field, 'Deve conter entre 3 a 100 caracteres');
            valid = false;
            return;
        }

        if(!/^[a-zA-Zà-úÀ-ÚçÇ\s\-,]+$/.test(pratoDesc)) {
            Error.criaErro(field, 'Deve conter apenas letras');
            valid = false;
        }

        return valid;
    }

    isCategoriaValid(field) {
        const categoria = field.value;
        const categorias = ['Entradas', 'Prato principal', 'Sobremesas', 'Cardapio infantil', 'Bebidas'];
        let valid = true

        if(!categorias.includes(categoria)) {
            valid = false;
            Error.criaErro(field, 'Categoria não existe');
        }

        return valid;
    }

    isImagemValid(field) {
        const imgFakePath = field.value;
        return true;
    }
}

export default new ValidaPratoForm();
