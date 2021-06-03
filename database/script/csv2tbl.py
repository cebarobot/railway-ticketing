import os
import csv

cwd = os.getcwd()
dir = "train-2016-10"


def get_time(s, day, flag, last_time):
    if s == '-':
        return 0, day, flag, last_time
    h, m = s.split(":")
    h_val = int(h)
    m_val = int(m)
    t = day * 1440 + h_val * 60 + m_val
    if flag == 0:
        flag = 1
    elif t < last_time:
        day = day + 1
        t = day * 1440 + h_val * 60 + m_val
    last_time = t
    h_new = t // 60
    m_new = t % 60
    new = str(h_new) + ":" + str(m_new)
    return new, day, flag, last_time


def get_price2(str):
    list = str.strip().split('/')
    if len(list) == 1:
        return '0', '0'
    else:
        s1, s2 = list
        p1 = ('0' if s1 == '-' else s1)
        p2 = ('0' if s2 == '-' else s2)
        return p1, p2


def get_price3(str):
    list = str.strip().split('/')
    if len(list) == 1:
        return '0', '0', '0'
    else:
        s1, s2, s3 = list
        p1 = ('0' if s1 == '-' else s1)
        p2 = ('0' if s2 == '-' else s2)
        p3 = ('0' if s3 == '-' else s3)
        return p1, p2, p3


def csv2tbl(filename, path):
    train_num = filename.split('.')[0]

    csvname = os.path.join(path, filename)
    train_tbl = os.path.join(cwd, "tbl", "train.tbl")
    price_tbl = os.path.join(cwd, "tbl", "ticketprice.tbl")

    csvfile = open(csvname, 'r', encoding='utf-8')
    f_train = open(train_tbl, 'a', encoding='utf-8')
    f_price = open(price_tbl, 'a', encoding='utf-8')

    reader = csv.DictReader(csvfile)

    flag = 0
    day = 0
    last_time = 0

    for row in reader:
        # keys = list(row.keys())
        vals = list(row.values())
        time1 = vals[2].strip()
        time2 = vals[3].strip()
        if time1 == '-':
            time1 = time2
        if time2 == '-':
            time2 = time1
        t1, day, flag, last_time = get_time(time1, day, flag, last_time)
        t2, day, flag, last_time = get_time(time2, day, flag, last_time)
        train = train_num + '|' + vals[0].strip() + '|' + vals[1].strip() + '|' + t1 + '|' + t2
        price = train_num + '|' + vals[0].strip() + '|'
        f_train.write(train)
        f_train.write('\n')

        yz, rz = get_price2(vals[7])
        yw1, yw2, yw3 = get_price3(vals[8])
        rw1, rw2 = get_price2(vals[9])

        price1 = price + 'YZ|' + yz
        f_price.write(price1)
        f_price.write('\n')

        price2 = price + 'RZ|' + rz
        f_price.write(price2)
        f_price.write('\n')

        price3 = price + 'YW1|' + yw1
        f_price.write(price3)
        f_price.write('\n')

        price4 = price + 'YW2|' + yw2
        f_price.write(price4)
        f_price.write('\n')

        price5 = price + 'YW3|' + yw3
        f_price.write(price5)
        f_price.write('\n')

        price6 = price + 'RW1|' + rw1
        f_price.write(price6)
        f_price.write('\n')

        price7 = price + 'RW2|' + rw2
        f_price.write(price7)
        f_price.write('\n')

    f_train.close()
    f_price.close()


if __name__ == '__main__':

    if not os.path.exists("tbl"):
        os.mkdir("tbl")

    for s in os.listdir(dir):
        full_dir = os.path.join(cwd, dir, s)
        if os.path.isdir(full_dir):
            for file in os.listdir(full_dir):
                full_file = os.path.join(full_dir, file)
                if os.path.isfile(full_file):
                    csv2tbl(file, full_dir)
