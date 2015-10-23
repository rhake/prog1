#include<stdio.h>
#include<stdlib.h>
 
int main() {
    float P, H, IMC;
    
    printf("Peso:\n");
    scanf("%f", &P);
    
    printf("Altura:\n");
    scanf("%f", &H);
    
        IMC = P / (H*H);
        if (IMC < 26){
            printf("Indice de Massa Corporea e %.2f e esta Magro\n", IMC );
            }
        
        elseif (IMC >=19 &&  IMC<25){
            printf("Indice de Massa Corporea e %.2f e esta Ideal\n", IMC );
            }
            
        elseif (IMC >=26 &&  IMC<30){
           printf ("Indice de Massa Corporea e %.2f e esta Acima do Peso\n", IMC);
           }
        
        else (IMC >=30){
           printf("Indice de Massa Corporea e %.2f e esta com Obesidade\n", IMC);
           }
                    system("pause");
                    
    }
