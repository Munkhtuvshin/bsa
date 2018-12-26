#include <stdio.h> 
#include <stdlib.h> 

/* ene morond 2 function zarlaj bna 
    compare_prt function n int torliin 2 parametertei bna. Int torol butsaadag bna.
    sort_array function n 3 parametertei bna ehnii parameter n zaagch bna uldsen n 2 n engiin bna  */ 
void sort_array(int *, int, int (*compare_ptr)(int, int)); 

/* 2 parametertei ter n 2uulaa int torliin zaagch bna*/ 
void swap(int *a, int *b); 

/* 2 parametertei 2uulaa int bna. Int torol butsaadag bna*/ 
int compare(int a, int b); 

/* 2 parametertei 2uulaa int bna. Int torol butsaadag bna*/ 
int reverse_compare(int a, int b); 

/* utga butsaahgui parameter negt int torliin zaagach bna, draagiinh n int toroltoi bna*/ 
void print_array(int *, int); 
  
int main(int argc, char *argv[]){ 

  const int ARRAY_SIZE = 10, MAX_NUMBER = 100; 
  int array[ARRAY_SIZE]; 
  
  int i; 
  //door sanamsargui too uusgeed array ruu hiij bna
  for(i = 0; i < ARRAY_SIZE; i++){ 
    array[i] =  1 + (int) (10.0 * (rand() / (RAND_MAX + 1.0))); 
  } 

  //sort hiihees omnoh array haruulj bna 
  //array-g hevlehdee print_array func-iig duudaj ajiluulna
  printf("Before sort\n"); 
  print_array(array, ARRAY_SIZE); 
  
  //array-g osohoor sortloj bna 
  sort_array(array, ARRAY_SIZE, &compare); 
  printf("After sorting with regular compare\n"); 
  print_array(array, ARRAY_SIZE); 
  
  //array=g buurhaar sortloj bn
  sort_array(array, ARRAY_SIZE, &reverse_compare); 
  printf("After sorting with reverse compare\n"); 
  print_array(array, ARRAY_SIZE); 
  
  return 0; 
} 
  
/* sort finctionii ih bie bna */ 
void sort_array(int *a, int size, int (*compare_ptr)(int,int)){ 
  int i, j; //davtaltand guih huvsagch 
  for(i = 0; i < size - 1; i++){ 
    for(j = i + 1; j < size; j++){ 

      //draalsan 2 elemntiig hoorond n hariultuulna 0 bolon 1 gsen utga irne
      if(compare_ptr(a[i], a[j])){ 
        swap(a+i, &a[j]);
         /* 1 gsen utga irsen tohioldold 2 elemnetiin bariig solino. 
         ehnii parameter n solih utgiin ehnii huvsagchiin uuriin dugaar bna. 
         draagiin parameter n a massiveiin j dehi indexeer utga avna
         */
      } 
    } 
  } 
} 
  
/* zaagchaaraa buyu * bgaa bolhoor zaagchiin utga n bna 2 utgiig hoorond n solij bna */ 
void swap(int *a, int *b){ 
  int tmp = *b; 
  *b = *a; 
  *a = tmp; 
} 
  
void print_array(int *a, int size){ 
  int i; 
  for(i = 0; i < size; i++){ 
    printf("%d ", a[i]); 
  } 
  printf("\n"); 
} 
  
/* parameteriin 2 utgiig hoorond n hariutsuulaad nohtsol unen bol 1 ugui bol 0 gsen utga butsaadag bna. */ 
int compare(int a, int b) { if ( a > b ) return 1; else return 0; } 
int reverse_compare(int a, int b) { if ( a < b ) return 1; else return 0; }
