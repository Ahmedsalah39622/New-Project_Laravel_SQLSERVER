import streamlit as st
import pyodbc

# Login Page
def login_page():
    st.title("SQL Server Dashboard")
    st.subheader("Login")

    server = st.text_input("Server Name", placeholder="e.g., localhost\\SQLEXPRESS")
    username = st.text_input("Username")
    password = st.text_input("Password", type="password")

    if st.button("Login"):
        if server and username and password:
            try:
                connection = pyodbc.connect(
                    f'DRIVER={{SQL Server}};SERVER={server};UID={username};PWD={password}'
                )
                st.session_state['connection'] = connection
                st.success("Login successful!")
                st.session_state['logged_in'] = True
            except Exception as e:
                st.error(f"Login failed: {e}")
        else:
            st.error("Please fill in all fields.")

# Database Selection
def database_selection():
    connection = st.session_state.get('connection')
    if connection:
        cursor = connection.cursor()
        cursor.execute("SELECT name FROM sys.databases")
        databases = [row[0] for row in cursor.fetchall()]

        selected_db = st.selectbox("Select a Database", databases)
        if selected_db:
            st.session_state['selected_db'] = selected_db
            st.success(f"Database '{selected_db}' selected.")

# Table Selection and Data Display
def table_selection():
    connection = st.session_state.get('connection')
    selected_db = st.session_state.get('selected_db')

    if connection and selected_db:
        connection.autocommit = True
        cursor = connection.cursor()
        cursor.execute(f"USE {selected_db}")
        cursor.execute("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES")
        tables = [row[0] for row in cursor.fetchall()]

        selected_table = st.selectbox("Select a Table", tables)
        if selected_table:
            cursor.execute(f"SELECT * FROM {selected_table}")
            data = cursor.fetchall()
            columns = [column[0] for column in cursor.description]

            st.write(f"Data from table '{selected_table}':")
            st.dataframe(data, columns=columns)

# Main Function
def main():
    if 'logged_in' not in st.session_state:
        st.session_state['logged_in'] = False

    if not st.session_state['logged_in']:
        login_page()
    else:
        st.sidebar.title("Navigation")
        options = ["Select Database", "View Table"]
        choice = st.sidebar.radio("Go to", options)

        if choice == "Select Database":
            database_selection()
        elif choice == "View Table":
            table_selection()

if __name__ == "__main__":
    main()
