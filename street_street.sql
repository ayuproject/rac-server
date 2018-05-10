SELECT 
    ta.id AS taid,
    ta.nama AS tanama,
    tj.id AS tjid1,
    tj.nama AS tjnama1,
    tj.location AS tjlocation1,
    tj.latlng1 AS tjlatlng11,
    tj.latlng2 AS tjlatlng21,
    tj1.id AS tjid2,
    tj1.nama AS tjnama2,
    tj1.location AS tjlocation2,
    tj1.latlng1 AS tjlatlng12,
    tj1.latlng2 AS tjlatlng22
FROM
    tb_angkot AS ta 
LEFT JOIN
    tb_angkot_jalan AS taj
ON
    ta.id=taj.id_angkot
LEFT JOIN
    tb_jalan AS tj
ON
    taj.id_jalan=tj.id
INNER JOIN
    tb_angkot_jalan AS taj1
ON
    ta.id=taj1.id_angkot
INNER JOIN
    tb_jalan AS tj1
ON
    taj1.id_jalan=tj1.id
AND
    tj1.nama LIKE '%siliwangi%'
WHERE
    tj.nama  LIKE '%pasirhayam%';
