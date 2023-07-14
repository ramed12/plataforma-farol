from dotenv import load_dotenv
from sqlalchemy import create_engine
import mysql.connector
import argparse
import pandas as pd
import os
import numpy
import csv
from datetime import datetime


def import_data(id_indicador, enum, status, notas, arq):
    # unpacking the tuple
    file_name, file_extension = os.path.splitext(arq)
    file_path = os.path.join(os.getcwd(), arq)

    if (file_extension.lower() == '.csv'):
        data = pd.read_csv(filepath_or_buffer=file_path, sep=';',
                           engine='python', encoding='ISO-8859-1')
    else:
        data = pd.read_excel(file_path)

    data.columns = data.columns.str.lower()
    data.columns = data.columns.str.normalize('NFKD').str.encode(
        'ascii', errors='ignore').str.decode('utf-8')
    data.columns = data.columns.str.replace(r'\W+', '', regex=True)

    data['id_indicador'] = id_indicador
    data['enum'] = enum
    data['status'] = status
    data['notas'] = notas
    # data['created_at'] = datetime.now()
    # data['updated_at'] = datetime.now()

    return data


def import_data_teste(arq):
    # unpacking the tuple
    file_name, file_extension = os.path.splitext(arq)
    file_path = os.path.join(os.getcwd(), arq)

    if (file_extension.lower() == '.csv'):
        print('ARQUIVO CSV')
        data = pd.read_csv(filepath_or_buffer=file_path, sep=';',
                           engine='python', encoding='ISO-8859-1')
    else:
        print('ARQUIVO EXCEL')
        data = pd.read_excel(file_path)

    data.columns = data.columns.str.lower()
    data.columns = data.columns.str.normalize('NFKD').str.encode(
        'ascii', errors='ignore').str.decode('utf-8')
    data.columns = data.columns.str.replace(r'\W+', '', regex=True)

    return data


def save_data(df):
    load_dotenv(os.getcwd()+'\.env')

    if (os.getenv('DB_CONNECTION') == 'mysql'):
        engine = create_engine('mysql+mysqlconnector://{0}:{1}@{2}/{3}'.format(os.getenv('DB_USERNAME'), os.getenv('DB_PASSWORD'),
                                                                               os.getenv('DB_HOST'), os.getenv('DB_DATABASE')))
    elif (os.getenv('DB_CONNECTION') == 'sqlsrv'):
        engine = create_engine('mssql+pyodbc://{0}:{1}@{2}/{3}?driver=ODBC+Driver+17+for+SQL+Server'.format(os.getenv('DB_USERNAME'), os.getenv('DB_PASSWORD'),
                                                                                                            os.getenv('DB_HOST'), os.getenv('DB_DATABASE')))

    # print(conn)

    query = 'SHOW COLUMNS FROM info_indicadores'

    with engine.begin() as conn:
        rs = pd.read_sql_query(sql=query, con=conn)
        fields = rs.Field.to_numpy()

        df = df.filter(items=fields)
        print(fields)
        print(df.head())

        df.to_sql(name='info_indicadores', con=conn,
                  if_exists='append',  index=False)


def list_column(df):
    load_dotenv(os.getcwd()+'\.env')
    engine = create_engine('mysql+mysqlconnector://{0}:{1}@{2}/{3}'.format(os.getenv('DB_USERNAME'), os.getenv('DB_PASSWORD'),
                                                                           os.getenv('DB_HOST'), os.getenv('DB_DATABASE')))

    # print(conn)
    query = 'SHOW COLUMNS FROM info_indicadores'

    with engine.begin() as conn:
        rs = pd.read_sql_query(sql=query, con=conn)
        fields = rs.Field.to_numpy()
        # filtros = numpy.append(fields, 'index')
        df = df.filter(items=fields)
        # print(filtros)
        # print(df.head())
        df.to_sql(name='info_indicadores', con=conn,
                  if_exists='append',  index=False)


if __name__ == '__main__':
    print('Iniciando importação de dados...')
    print(os.getcwd())
    argParser = argparse.ArgumentParser()
    argParser.add_argument('-i', '--id_indicador', help="ID do indicador")
    argParser.add_argument('-e', '--enum', help="Enum do indicador")
    argParser.add_argument('-s', '--status', help="Status do indicador")
    argParser.add_argument('-n', '--notas', help="Notas do indicador")
    argParser.add_argument('-a', '--arq', help="Arquivo do indicador")
    args = argParser.parse_args()
    df = import_data(args.id_indicador, args.enum,
                     args.status, args.notas, args.arq)
    # df = import_data_teste('MICRODADOS_CADASTRO_CURSOS_2021_.CSV')
    # list_column(df)
    save_data(df)
    print('Dados importados com sucesso!')
