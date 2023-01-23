

const isEmail = (string) => {
    const pattern = /\S+@\S+\.\S+/;
    return pattern.test(string);
};

