filename = "train-2016-10\\all-stations.txt"
res = "tbl\\station.tbl"

f = open(filename, 'r', encoding='utf-8')
f_sta = open(res, 'w', encoding='utf-8')

for line in f:
    num, station, city = line.strip().split(',')
    row = station + '|' + city
    f_sta.write(row)
    f_sta.write('\n')

f_sta.close()