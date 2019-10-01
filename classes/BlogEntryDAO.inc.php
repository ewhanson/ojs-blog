<?php

/**
 * @file classes/BlogEntryDAO.inc.php
 *
 *
 * @package plugins.generic.blog
 * @class BlogEntryDAO
 * Operations for retrieving and modifying blog objects.
 */

import('lib.pkp.classes.db.DAO');
import('plugins.generic.blog.classes.BlogEntry');

class BlogEntryDAO extends DAO {

	/**
	 * Get a blog entry by ID
	 * @param $blogEntryId int blog ID
	 */
	function getById($blogEntryId) {
		$params = array((int) $blogEntryId);
		$result = $this->retrieve('SELECT * FROM blog_entries WHERE entry_id = ?',
			$params);
		$returner = null;
		if ($result->RecordCount() != 0) {
			$returner = $this->_fromRow($result->GetRowAssoc(false));
		}
		$result->Close();
		return $returner;
	}

	/**
	 * Get a set of blog entries by context ID
	 * @param $contextId int
	 * @param $rangeInfo Object optional
	 * @return DAOResultFactory
	 */
	function getByContextId($contextId, $rangeInfo = null) {
		$result = $this->retrieveRange(
			'SELECT * FROM blog_entries WHERE context_id = ? order by date_posted desc',
			(int) $contextId,
			$rangeInfo
		);

		return new DAOResultFactory($result, $this, '_fromRow');
	}

	/**
	 * Insert a blog entry.
	 * @param $blogEntry BlogEntry
	 * @return int Inserted blogEntryID
	 */
	function insertObject($blogEntry) {
		$valArray = [(int) $blogEntry->getContextId(), $blogEntry->getTitle(), $blogEntry->getContent(), Core::getCurrentDate()];

		$this->update(
		   'INSERT INTO blog_entries (context_id, title, content, date_posted) VALUES (?,?,?,?)',
			$valArray
		);

		$blogEntry->setId($this->getInsertId());

		return $blogEntry->getId();
	}

	/**
	 * Update the database with a blogEntry object
	 * @param $blogEntry BlogEntry
	 */
	function updateObject($blogEntry) {
		$this->update(
			'UPDATE	blog_entries
			SET	context_id = ?, title = ?, content = ? 
			WHERE	entry_id = ?',
			array(
				(int) $blogEntry->getContextId(),
				$blogEntry->getTitle(),
				$blogEntry->getContent(),
				(int) $blogEntry->getId()
			)
		);
	}

	/**
	 * Delete blog entry by ID.
	 * @param $blogEntry int
	 */
	function deleteById($entryId) {
		$this->update(
			'DELETE FROM blog_entries WHERE entry_id = ?',
			(int) $entryId
		);
	}

	/**
	 * Delete a blog entry object.
	 * @param $blogEntry BlogEntry
	 */
	function deleteObject($blogEntry) {
		$this->deleteById($blogEntry->getId());
	}

	/**
	 * Generate a new blog entry object.
	 * @return blogEntry
	 */
	function newDataObject() {
		return new BlogEntry();
	}

	/**
	 * Return a new blog entry object from a given row.
	 * @return blogEntry
	 */
	function _fromRow($row) {
		$blogEntry = $this->newDataObject();
		$blogEntry->setId($row['entry_id']);
		$blogEntry->setContextId($row['context_id']);
		$blogEntry->setTitle($row['title']);
		$blogEntry->setContent($row['content']);
		$blogEntry->setDatePosted($row['date_posted']);
		return $blogEntry;
	}

	/**
	 * Get the insert ID for the last inserted blog entry.
	 * @return int
	 */
	function getInsertId() {
		return $this->_getInsertId('blog_entries', 'entry_id');
	}



	/**
	 * Get blog entry posted datetime.
	 * @return datetime (YYYY-MM-DD HH:MM:SS)
	 */
	function getDatetimePosted() {
		return $this->getData('datePosted');
	}

	/**
	 * Set blog entry posted datetime.
	 * @param $datetimePosted date (YYYY-MM-DD HH:MM:SS)
	 */
	function setDatetimePosted($datetimePosted) {
		$this->setData('datePosted', $datetimePosted);
	}




}

