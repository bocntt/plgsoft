<?php
class class_Pagings {
	var $firstPage;
	var $previousPage;
	var $currentPage;
	var $nextPage;
	var $lastPage;
	var $blockPages = 10;
	var $currentBlockPages;
	var $startPage;
	var $endPage;
	var $totalRecords;
	var $totalRecordsInPage;

	function class_Pagings($currentPage, $totalRecords, $totalRecordsInPage) {
		$this->totalRecords = $totalRecords;
		$this->totalRecordsInPage = $totalRecordsInPage;
		$this->firstPage = 1;
		$this->lastPage = $this->roundUpNumber($totalRecords/$totalRecordsInPage);
		if (($currentPage < $this->firstPage) || ($currentPage > $this->lastPage)) $currentPage = 1;
		$this->currentPage = $currentPage;
		$this->previousPage = $this->currentPage - 1;
		if ($this->previousPage < $this->firstPage) $this->previousPage = $this->firstPage;
		$this->nextPage = $this->currentPage + 1;
		if ($this->nextPage > $this->lastPage) $this->nextPage = $this->lastPage;

 		$this->currentBlockPages = ceil($this->currentPage/$this->blockPages);
 		$this->currentBlockPages = $this->currentBlockPages-1;
 		if ($this->currentBlockPages < 0) $this->currentBlockPages = 0;
 		$this->startPage = $this->currentBlockPages * $this->blockPages + 1;
 		$this->endPage = ($this->currentBlockPages+1) * $this->blockPages;
 		if ($this->endPage > $this->lastPage) $this->endPage = $this->lastPage;
 		if (($this->currentPage < $this->startPage) || ($this->currentPage > $this->endPage)) $this->currentPage = $this->startPage;
	}

	function roundUpNumber($number) {
		if ($number == 0) $numberTemp = 0;
		else $numberTemp = round($number);
		$numberTemp = round($number);
		if ($number <= $numberTemp) return $numberTemp;
		else return $numberTemp + 1;
	}

	function getFirstPage() {
		return $this->firstPage;
	}
	function setFirstPage($firstPage) {
		$this->firstPage = $firstPage;
	}

	function getPreviousPage() {
		return $this->previousPage;
	}
	function setPreviousPage($previousPage) {
		$this->previousPage = $previousPage;
	}

	function getCurrentPage() {
		return $this->currentPage;
	}
	function setCurrentPage($currentPage) {
		$this->currentPage = $currentPage;
	}

	function getNextPage() {
		return $this->nextPage;
	}
	function setNextPage($nextPage) {
		$this->nextPage = $nextPage;
	}

	function getLastPage() {
		return $this->lastPage;
	}
	function setLastPage($lastPage) {
		$this->lastPage = $lastPage;
	}

	function getBlockPages() {
		return $this->blockPages;
	}
	function setBlockPages($blockPages) {
		$this->blockPages = $blockPages;
	}

	function getCurrentBlockPages() {
		return $this->currentBlockPages;
	}
	function setCurrentBlockPages($currentBlockPages) {
		$this->currentBlockPages = $currentBlockPages;
	}

	function getStartPage() {
		return $this->startPage;
	}
	function setStartPage($startPage) {
		$this->startPage = $startPage;
	}

	function getEndPage() {
		return $this->endPage;
	}
	function setEndPage($endPage) {
		$this->endPage = $endPage;
	}

	function getTotalRecords() {
		return $this->totalRecords;
	}
	function setTotalRecords($totalRecords) {
		$this->totalRecords = $totalRecords;
	}

	function getTotalRecordsInPage() {
		return $this->totalRecordsInPage;
	}
	function setTotalRecordsInPage($totalRecordsInPage) {
		$this->totalRecordsInPage = $totalRecordsInPage;
	}

	function printPagings($formTag, $pageTag) {
		echo '<script type="text/javascript">';
		echo 'function goToPageOfPagings(formTag, pageTag, pageValue) {
			formTagObj = document.getElementById(formTag);
			pageTagObj = document.getElementById(pageTag);
			if ((formTagObj != null) && (pageTagObj != null)) {
				pageTagObj.value = pageValue;
				formTagObj.submit();
			}
		}';
		echo '</script>';
		if ($this->totalRecords == 0) {
			echo "";
		} else {
			echo '<ul class="pagination">';
			if($this->currentPage == $this->firstPage) {
				echo '<li><a href="javascript:void(0);" class="not_current_paging">First</a></li>';
			} else {
				echo '<li><a href="javascript:void(0);" onclick="goToPageOfPagings(\''.$formTag.'\', \''.$pageTag.'\', \''.$this->firstPage.'\');" class="not_current_paging">First</a></li>';
			}
			if($this->currentPage == $this->previousPage) {
				echo '<li><a href="javascript:void(0);" class="not_current_paging">Previous</a></li>';
			} else {
				echo '<li><a href="javascript:void(0);" onclick="goToPageOfPagings(\''.$formTag.'\', \''.$pageTag.'\', \''.$this->previousPage.'\');" class="not_current_paging">Previous</a></li>';
			}
			for($i=$this->startPage; $i<=$this->endPage; $i++) {
				if ($i==$this->currentPage) {
					echo '<li><a href="javascript:void(0);" class="current_paging">'.$i.'</a></li>';
				} else {
					echo '<li><a href="javascript:void(0);" onclick="goToPageOfPagings(\''.$formTag.'\', \''.$pageTag.'\', \''.$i.'\');" class="not_current_paging">'.$i.'</a></li>';
				}
			}
			if($this->currentPage == $this->nextPage) {
				echo '<li><a href="javascript:void(0);" class="not_current_paging">Next</a></li>';
			} else {
				echo '<li><a href="javascript:void(0);" onclick="goToPageOfPagings(\''.$formTag.'\', \''.$pageTag.'\', \''.$this->nextPage.'\');" class="not_current_paging">Next</a></li>';
			}
			if($this->currentPage == $this->lastPage) {
				echo '<li><a href="javascript:void(0);" class="not_current_paging">Last</a></li>';
			} else {
				echo '<li><a href="javascript:void(0);" onclick="goToPageOfPagings(\''.$formTag.'\', \''.$pageTag.'\', \''.$this->lastPage.'\');" class="not_current_paging">Last</a></li>';
			}
			echo '</ul>';
		}
	}
}
?>
