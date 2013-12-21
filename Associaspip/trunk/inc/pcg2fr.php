<?php
/***************************************************************************\
 *  ComptaSPIP, extension comptable
 *
 * @read (licence, copyrigth, authors, credits)
 *  ../plugin.xml
\***************************************************************************/

return array(
	'[1-8]', //0: classes
	'[0-9]', //1: sections (mais pas de : 24 30 55 56 57 81 82 83 84 85 !)
	'[0-9]', //2: groupes (mais pas de : 100 111 112 113 114 116 117 118 121 122 123 124 125 126 127 128 130 131 132 133 134 135 136 137 140 149 150 152 159 160 170 172 173 175 176 177 179 180 182 183 184 189 190 191 192 196 200 202 204 209 210 216 217 219 220 222 224 225 226 227 230 233 234 235 236 239 240 250 251 252 253 254 255 256 257 258 259 260 263 264 265 270 278 283 284 285 286 287 288 289 294 295 298 299 300 301 302 303 304 305 306 307 308 309 310 313 314 315 316 318 319 320 324 325 327 328 329 330 332 333 334 336 337 338 339 340 342 343 344 346 347 348 349 350 352 353 354 356 357 359 360 361 362 363 364 365 366 367 368 369 370 373 374 375 376 377 378 379 380 381 382 383 384 385 386 387 388 389 390 396 398 399 402 406 407 412 414 415 420 430 431 432 433 434 435 436 439 440 450 452 453 454 459 460 461 463 466 469 470 473 474 479 480 482 483 484 485 490 492 493 494 497 498 499 500 510 520 521 522 523 524 525 526 527 528 529 530 535 536 537 538 539 540 543 544 545 546 547 548 549 550 551 552 553 554 555 556 557 558 559 560 561 562 563 564 565 566 567 568 569 570 571 572 573 574 575 576 577 578 579 580 581 582 583 584 585 586 587 588 589 591 592 593 594 595 596 597 598 599 600 610 620 630 636 638 639 640 642 643 649 650 652  656 659 660 662 663 669 670 673 674 676 677 679 680 682 683 684 685 688 690 692 693 694 700 710 711 712 714 715 716 717 718 719 723 724 725 726 727 728 729 730 732 733 734 735 736 737 738 743 744 745 746 747 748 749 750 759 760 769 770 773 774 776 779 780 782 783 784 785 788 790 792 793 794 795 798 799 800 803 804 805 806 807 808 863 865 866 867 867 868 869 872 873 874 876 877 878 879 892 893 894 895 896 897 898 899 81x 82x 83x 84x 85x)
	'A' => array(6,7), // classes de gestion
	'B' => array(1,2,3,4,5), // classes de bilan
	'C' => '1018|(1[12]0)|(16[1236])|187|(2[67]9)|(28[012])|(29[012367])|(39[123457])|(40[3458])|419|(42[14])|(428[246])|(44[13]9)|442|4457|(4458[47])|(44[67])|(448[267])|455|(456[34])|464|4686|477|487|(49[156])|(5[01]9)|5186|590|(6[0-9]9)|(7[0-9][0-2])|(7[0-9][4-8])|802', // comptes au credit
	'D' => '(1[01236]9)|186|409|4117|(41[368])|(42[57])|4287|(44[13][0-8])|4456|(4458[1236])|(456[26])|(46[25])|4687|476|(48[16])|(5[013]1)|(51[456])|5187|(53[23])|(6[0-9][0-8])|(7[0-9]9)|801', // comptes au debit
);

// Plan comptable prenant en compte les nouvelles dispositions du règlement :
// N° 99-08 et n° 99-09 du 24 novembre 1999 (publiés dans le JO du 31/12/1999);
// N° 99-03 du 29 avril 1999 du Comité de la réglementation comptable (publié dans le JO du 21/09/1999);
// N° 99-01 du 16 février 1999 relatif aux modalités d’établissement des comptes annuels des associations et fondations ;
//
// NB : organisme = association/entreprise/société/exploitant
//
// http://www.plancomptable.com/titre-IV/liste_des_comptes_sb.htm
// http://www.formation-logiciel-comptabilite.fr/Plan-comptable-definition-et-PCG?lang=fr
// http://fr.wikipedia.org/wiki/Plan_comptable_g%C3%A9n%C3%A9ral_%28France%29
// http://www.expertisecomptable-foucher.com/sup/download2.php?file_id=4124
// http://lump.pagesperso-orange.fr/compta.htm
// http://www.mesexercices.com/recherche_information/comptabilite-les-comptes-de-classe-6-charges-sont-normalement_6_38694.htm
//  http://dz.viadeo.com/fr/questions/repondre/?questionId=0021aox4cgt6v70a
// Plan comptable général 2008, Éditions Economica, 2006 : ref.KPMG=1356 ; EAN=978-2-7178-5565-4

?>