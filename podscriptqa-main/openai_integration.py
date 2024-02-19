import openai
import os

# Load the OpenAI API key from an environment variable
openai.api_key = os.getenv('OPENAI_API_KEY')

def answer_question_with_gpt(context, question):
    try:
        response = openai.ChatCompletion.create(
            model="gpt-3.5-turbo",
            messages=[
                {"role": "system", "content": "You are a helpful assistant."},
                {"role": "user", "content": context},
                {"role": "user", "content": f"Question: {question}"}
            ]
        )
        return response.choices[0].message['content']
    except openai.error.OpenAIError as e:
        return f"An error occurred: {str(e)}"
