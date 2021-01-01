#include <stdio.h>
#include <conio.h>
#include <stdlib.h>
#include <math.h>
#define maxlength 250
#define EMPTY 0

//me cung n x m
//1 la tuong
//0 la duong di
//2 la diem bat dau 
//3 la diem ket thuc
//GOAL : duong di cua me cung 
//input : dau vao, dau ra , tuong
const char* action[] = {
	"START -->","UP -->","DOWN -->",
	"LEFT -->","RIGHT -->"
};
//cau truc me cung 

typedef struct State{
	int n,m; // chieu cao va rong.
	int a[maxlength][maxlength]; 
	int x,y; // vi tri hien tai
	int x_goal,y_goal;
}State;

int compareStates(State state1, State state2){
	if(state1.x == state2.x && state1.y == state2.y ){
		return 1;
	}
	return 0;
}
int goalcheck(State state){
	return state.a[state.x][state.y] == 3;
}
void printState(FILE *fptr, State state){
	int i,j;
	//fprintf(fptr, "%d %d\n",state.x,state.y);
	for (i=0; i<state.n; i++){
		for(j=0;j<state.m;j++){
			fprintf(fptr,"%d ",state.a[i][j]);
		}
		fprintf(fptr,"\n");
	}
}
int check( State state, int x, int y )	//kiem tra (x,y) co trong maze khong
{
	 if ( x < 0 ||  x >= state.n) return 0;
	 if ( y < 0 ||  y >= state.m) return 0;
//	if(a[x][y]<0 || a[x][y]>1) return 0;
	 return 1;
}

int up(State state, State* result){
	if(state.a[state.x-1][state.y] != 1 && check( state, state.x-1, state.y )){
		*result = state;
		result->x = state.x - 1;
		return 1;
	} 
	return 0;
}
int down(State state, State* result){
	if(state.a[state.x+1][state.y] != 1 && check( state, state.x+1, state.y )){
		*result = state;
		result->x = state.x + 1;
		return 1;
	} 
	return 0;
}

int left(State state, State* result){
	if(state.a[state.x][state.y-1] != 1 && check( state, state.x, state.y-1 )){
		*result = state;
		result->y = state.y - 1;
		return 1;
	} 
	return 0;
}

int right(State state, State* result){
	if(state.a[state.x][state.y+1] != 1 && check( state, state.x, state.y+1 )){
		*result = state;
		result->y = state.y + 1;
		return 1;
	} 
	return 0;
}
callOperators(State state, State* result,int opt){
	switch(opt){
		case 1 : return up(state, result);
		case 2 : return down(state, result);
		case 3 : return left(state, result);
		case 4 : return right(state, result);
		default: printf("Cannot call operator");
	}	
}
float heuristic(State state){
	return sqrt((state.x_goal-state.x)*(state.x_goal-state.x)
			+(state.y_goal-state.y)*(state.y_goal-state.y));		
}

// Khai bao cau truc cay tim kiem 
typedef struct Node{
	State state;
	struct Node* parent;
	int no_function;
	int h;
	int f;
	int g;
}Node;

//Cai dat cau truc danh sach  
typedef struct {
	Node* elements[maxlength];
	int size;
}List;
void makeNull_List(List* list){
	list->size=0;
}
int empty_List (List list){
	return (list.size == 0);
}
int full_List (List list){
	return(list.size > maxlength );
}
Node* element_at(int p, List list){
	return list.elements[p-1];
}
//Them phan tu vao list
void push_List(Node* x, int position, List* list){
	if(!full_List(*list)){
		int q;
		for(q=list->size; q>=position; q--)
			list->elements[q] = list->elements[q-1];
		list->elements[position-1]=x;
		list->size++;
	}
	else printf("Full list\n");
}
void delete_List(int position, List* list){
	if(empty_List(*list))
		printf("Empty list");
	else if(position<1 || position > list->size ){
		printf("Position is not possible to delete list");
	}
	else {
		int i;
		for(i=position-1;i<list->size;i++)
			list->elements[i] = list->elements[i+1];
		list->size--;
	}
}
// Tim trang thai
Node* find_State (State state, List list,int* position){
	int i;
	for (i=1 ; i<=list.size ; i++){
		if(compareStates(state, element_at(i, list)->state)){
			*position =i;
			return element_at(i,list);
		}
	}
	return NULL;
}
// Sap xep theo h
void sort_List(List* list){
	int i,j;
	for(i=0; i<list->size-1 ; i++)
		for(j=i+1; j<list->size; j++)
			if(list->elements[i]->h > list->elements[j]->h){
				Node* node = list->elements[j];
				list->elements[j] = list->elements[i];
				list->elements[i] = node;
			}
}
Node* A_Star(FILE* output,State state){
	List Open_A_Star;
	List Close_A_Star;
	makeNull_List(&Open_A_Star);
	makeNull_List(&Close_A_Star);
	Node* root = (Node*) malloc(sizeof(Node));
	root->state = state;
	root->parent = NULL;
	root->no_function = 0;
	root->g=0;
	root->h = heuristic(root->state);
	root->f= root->g + root->h;
	push_List(root,Open_A_Star.size+1, &Open_A_Star);
	while(!empty_List(Open_A_Star)){
		Node* node = element_at(1,Open_A_Star);
		delete_List(1,&Open_A_Star);
		push_List(node, Close_A_Star.size+1, &Close_A_Star);
		if(goalcheck(node->state)){			
			return node;
		}
		int opt;
		for(opt=1;opt<=4;opt++){
			State newstate;
			if(callOperators(node->state, &newstate, opt)){
				Node* newNode = (Node*)malloc(sizeof(Node));
				newNode->state = newstate;
				newNode->parent = node;
				newNode->no_function = opt;
				newNode->g = node->g + 1;
				newNode->h = heuristic(newstate);
				newNode->f = newNode->g + newNode->h;
				//Kiem tra trang thai moi sinh cos thuoc Open_A_Star, Close_A_Star khong
				int pos_Open, pos_Close;
				Node* nodeFoundOpen= find_State(newstate, Open_A_Star, &pos_Open);
				Node* nodeFoundClose= find_State(newstate, Close_A_Star, &pos_Close);
				if(nodeFoundOpen == NULL && nodeFoundClose == NULL)
					push_List(newNode, Open_A_Star.size+1, &Open_A_Star);
					else if(nodeFoundOpen != NULL && nodeFoundOpen->g > newNode->g ){
						delete_List(pos_Open,&Open_A_Star );
						push_List(newNode, pos_Open, &Open_A_Star);
					}
						else if(nodeFoundClose != NULL && nodeFoundClose->g > newNode->g){
							delete_List(pos_Close,&Close_A_Star );
							push_List(newNode,Open_A_Star.size+1 , &Open_A_Star);
						}
						sort_List(&Open_A_Star);
			}
		}
	}
	printf("FALSE");
	return NULL;
}
void print_WaysToGetGoal(FILE* fptr, Node* node){
	State temp= node->state;
	if(node == NULL){
		printf("\nnode is NULL");
		return ;	
	}
	List listPrint;
	makeNull_List(&listPrint);
	//Duyet nguoc ve nut parent
	while(node->parent != NULL){
		push_List(node, listPrint.size+1, &listPrint);
		node = node->parent;
	}
	push_List(node, listPrint.size+1, &listPrint);
	//In ra
	int no_action=0, i;
	for(i=listPrint.size; i>0;i--){
		fprintf(fptr,"%d\n",element_at(i,listPrint)->state.x*element_at(i,listPrint)->state.m+element_at(i,listPrint)->state.y);

		no_action++;
	}
}

int main(){
	State state;
	state.x = 1;
	state.y = 1;
	FILE *fptr;
	FILE *fptr1;
	fptr = fopen("input.txt","rb");
	fptr1 = fopen("output.txt","wb");
	fscanf(fptr,"%d%d",&state.n,&state.m);
	int i,j; 
	for (i=0; i<state.n; i++)
		for(j=0;j<state.m;j++){
			fscanf(fptr,"%d",&state.a[i][j]);
			if(state.a[i][j] == 2){
				state.x = i;
				state.y = j;
			}
			else if(state.a[i][j] == 3){
				state.x_goal = i;
				state.y_goal = j;
			}
		}
	State result;

	Node* p = A_Star(fptr1, state);
	print_WaysToGetGoal(fptr1,p);
	return 0;
}
