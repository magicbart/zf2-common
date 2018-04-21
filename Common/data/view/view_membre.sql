DROP VIEW IF EXISTS view_membre;
CREATE VIEW view_membre
AS SELECT
	a.idMembre,
	a.pseudo,
	a.avatar,
	a.forum_nbMessage,
	a.forum_idRang,
	a.sexe,
    t.tag,
	b.idPays,
	b.libPays_fr,
	b.libPays_en,
	b.classPays,
	b.codeIso,
	d.statut_fr,
	d.statut_en
FROM t_membre a
INNER JOIN t_pays b ON a.idPays = b.idPays
INNER JOIN t_membre_statut d ON a.idStatut = d.idStatut
LEFT JOIN t_team t ON a.idTeam = t.idTeam;