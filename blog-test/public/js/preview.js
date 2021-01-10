const loadFile = (event) => {
    console.log(222);
    const reader = new FileReader();
    reader.onload = () => {
        const output = document.getElementById('output');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};