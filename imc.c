#include <stdio.h>

int main(void) {
    float peso, altura, imc;

    printf("Peso (kg): ");
    fflush(stdout);
    if (scanf("%f", &peso) != 1 || peso <= 0) {
        fprintf(stderr, "Peso inválido. Informe um número maior que zero.\n");
        return 1;
    }

    printf("Altura (m): ");
    fflush(stdout);
    if (scanf("%f", &altura) != 1 || altura <= 0) {
        fprintf(stderr, "Altura inválida. Informe um número maior que zero.\n");
        return 1;
    }

    imc = peso / (altura * altura);

    if (imc < 19) {
        printf("O seu índice de massa corpórea é %.2f: você está magro.\n", imc);
    } else if (imc < 25) {
        printf("O seu índice de massa corpórea é %.2f: você está no peso ideal.\n", imc);
    } else if (imc < 30) {
        printf("O seu índice de massa corpórea é %.2f: você está acima do peso.\n", imc);
    } else {
        printf("O seu índice de massa corpórea é %.2f: você está com obesidade.\n", imc);
    }

    return 0;
}
