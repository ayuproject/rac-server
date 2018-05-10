SELECT 
    ta.id AS taid,
    ta.nama AS tanama,
    tt.nama AS ttnama,
    tj.nama AS tjnama
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
LEFT JOIN
    tb_angkot_jalan AS taj
ON
    ta.id=taj.id_angkot
LEFT JOIN
    tb_jalan AS tj
ON
    taj.id_jalan=tj.id
WHERE
    tt.nama LIKE '%bri%'
AND
    tj.nama LIKE '%sili%';