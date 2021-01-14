const loadFile = (files) => {
    const output = document.getElementById('output');
    output.innerHTML = '';
    [...files].forEach( file =>{

        const reader = new FileReader();

        reader.onload = () => {
            const image = `<img src="${reader.result}">`;
            output.insertAdjacentHTML('beforeend', image);
        };
        reader.readAsDataURL(file);

    });
};