function calculateAge(birthdate: string): number {
    const today = new Date();
    const birthDate = new Date(birthdate);
    let age = today.getFullYear() - birthDate.getFullYear();
    const month = today.getMonth();
    const day = today.getDate();

    // Adjust age if birthday hasn't occurred yet this year
    if (month < birthDate.getMonth() || (month === birthDate.getMonth() && day < birthDate.getDate())) {
        age--;
    }

    return age;
}

// Example usage
const birthdate = "1990-05-14";  // Replace with your birthdate__
const age = calculateAge(birthdate);
console.log(`Your age is: ${age}`);
