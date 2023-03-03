import os
import urllib.parse

query_dict = urllib.parse.parse_qs(os.environ['QUERY_STRING'])

def greeter(name, surname):
    return ('Hello'+ str(name).capitalice()+ ' '+str(surname).capitalice()+ ' how are you')


input_name = str(query_dict['name'])[2:-2]
input_surname = str(query_dict['surname'])[2:-2]

print("Content-Type: text/html\n")

print(greeter(input_name, input_surname))

