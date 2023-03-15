const isSame = (val1, val2) => {
    return val1 === val2;
}

const isValidForm = (form) => {
    return form.reportValidity() === true;
}

export { isSame, isValidForm };