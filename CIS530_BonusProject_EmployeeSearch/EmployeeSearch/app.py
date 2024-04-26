from flask import Flask, render_template, request, jsonify
import pyodbc

app = Flask(__name__)

connection_string = (
    f'DRIVER={{SQL Server}};'
    f'SERVER=DESKTOP-52QCFAR;'
    f'DATABASE=Company_SarLoka;'
    f'Trusted_Connection=yes;'
)

def fetch_employee_details(empLastName):
    try:
        connection = pyodbc.connect(connection_string)
        with connection.cursor() as cursor:
            query = "SELECT FNAME, LNAME, SSN, BDATE FROM EMPLOYEE WHERE LNAME=?"
            cursor.execute(query, empLastName)
            result = cursor.fetchall()
            return result
    finally:
        if connection:
            connection.close()

@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        message=''
        empLastName = request.form['LastName']
        if not empLastName:
            return render_template('EmpSearch.html', message='Last name not provided!')
        employeeData = fetch_employee_details(empLastName)
        if not employeeData:
            return render_template('EmpSearch.html', message='No employee data found with the name entered!')
        else:
            return render_template('EmpSearch.html', employeeData=employeeData)
    else:
        return render_template('EmpSearch.html')

if __name__ == '__main__':
    app.run(debug=True, port=8000)


