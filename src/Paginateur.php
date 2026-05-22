<?php

namespace Fleche;

class Paginateur
{
    public readonly int $totalPages;
    public readonly bool $aPrecedent;
    public readonly bool $aSuivant;

    public function __construct(
        public readonly array $items,
        public readonly int   $total,
        public readonly int   $page,
        public readonly int   $parPage
    ) {
        $this->totalPages = (int) ceil($total / $parPage);
        $this->aPrecedent = $page > 1;
        $this->aSuivant   = $page < $this->totalPages;
    }

    public function pagePrecedente(): int
    {
        return max(1, $this->page - 1);
    }

    public function pageSuivante(): int
    {
        return min($this->totalPages, $this->page + 1);
    }

    public function liens(string $urlBase, string $parametre = 'page'): string
    {
        if ($this->totalPages <= 1) {
            return '';
        }

        $html = '<nav class="pagination">';

        if ($this->aPrecedent) {
            $html .= "<a href=\"{$urlBase}?{$parametre}={$this->pagePrecedente()}\">&laquo; Précédent</a> ";
        }

        for ($i = 1; $i <= $this->totalPages; $i++) {
            $actif = $i === $this->page ? ' class="active"' : '';
            $html .= "<a href=\"{$urlBase}?{$parametre}={$i}\"{$actif}>{$i}</a> ";
        }

        if ($this->aSuivant) {
            $html .= "<a href=\"{$urlBase}?{$parametre}={$this->pageSuivante()}\">Suivant &raquo;</a>";
        }

        $html .= '</nav>';
        return $html;
    }

    public function versTableau(): array
    {
        return [
            'items'       => $this->items,
            'total'       => $this->total,
            'par_page'    => $this->parPage,
            'page'        => $this->page,
            'total_pages' => $this->totalPages,
            'a_precedent' => $this->aPrecedent,
            'a_suivant'   => $this->aSuivant,
        ];
    }
}
