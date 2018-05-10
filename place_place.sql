SELECT 
    ta.id AS taid,
    ta.nama AS tanama,
    tt.id AS ttid1,
    tt.nama AS ttnama1,
    tt.latlng AS ttlatlng1,
    tt1.id AS ttid2,
    tt1.nama AS ttnama2,
    tt1.latlng AS ttlatlng2
FROM
    tb_angkot AS ta 
LEFT JOIN
    tb_angkot_tempat AS tat
ON
    ta.id=tat.id_angkot
LEFT JOIN
    tb_tempat AS tt
ON
    tat.id_tempat=tt.id
INNER JOIN
    tb_angkot_tempat AS tat1
ON
    ta.id=tat1.id_angkot
INNER JOIN
    tb_tempat AS tt1
ON
    tat1.id_tempat=tt1.id
AND
    tt1.nama LIKE '%bupati%'
WHERE
    tt.nama  LIKE '%bri%';
