"""
Simple implementation for multi thread testing
"""
import datetime
import logging
import os
import sys

from HtmlTestRunner import HTMLTestRunner
from concurrent.futures import ThreadPoolExecutor

from test_cases_data import (MoveDevice,
                             Permissions,
                             AddDevice,
                             NameDuplication)


class Suite:
    """
    unittest SuiteCase class does not fit well with multithreading tasks
    case - class containing an instance of a unittest test case
    and a list of test names
    """

    def __init__(self, name: str, threads: int) -> None:
        self.name = name
        self.threads = threads
        self.case_list = []
        self.dir_name = self._get_dir_name()

    def add_case(self, case: object) -> None:
        """
        Add new case

        Args:
            case (case): Class containing an instance of a unittest test case
        and a list of test names

        Returns:
            None
        """
        self.case_list.append(case)

    def _create_report_dir(self) -> None:
        """
        Create directory for report files

        Returns:
            None
        """
        if not os.path.exists(self.dir_name):
            os.mkdir(self.dir_name)

    def _create_logger(self) -> None:
        """
        Create logger and log file

        Returns:
            None
        """
        format = '%(asctime)s %(msecs)d %(name)s %(levelname)s %(message)s'
        logging.basicConfig(filename=f"{self.dir_name}/debug.log",
                            filemode='a',
                            format=format,
                            datefmt='%H:%M:%S',
                            level=logging.INFO)

    def _get_dir_name(self) -> str:
        """
        Get report directory name

        Returns:
            dir_name (str): Report directory name
        """
        dir_name = f"{os.environ.get('BASE_TEST_DIR')}" \
            f"{os.environ.get('TEST_RESULTS_PATH')}{self.name}_" \
            f"{datetime.datetime.today().strftime('%Y-%m-%d_%H-%M-%S')}"
        return dir_name

    def _pre_run(self) -> None:
        """
        Preps for suite run

        Returns:
            None
        """
        self._create_report_dir()
        self._create_logger()

    def run_suite(self) -> int:
        """
        Run suite and return final status code

        Returns:
            final_status_code (str): Suite final status code
        """
        self._pre_run()
        final_status_code = 0
        for case in self.case_list:
            test_results = self._run_thread_pool(case)
            status_code = self._get_case_status_code(test_results)
            final_status_code += status_code
        if final_status_code != 0:
            return 1
        return 0

    def _run_thread_pool(self, case: object) -> dict:
        """
        Run thread pool and return results

        Args:
            case (case): Class containing an instance of a unittest test case
        and a list of test names

        Returns:
            test_results (dict): Test results
        """
        test_results = {}
        test_case_repeat = [case.test_case_class]*len(case.test_list)
        with ThreadPoolExecutor(max_workers=int(self.threads)) as executor:
            result = executor.map(self._run_single_test,
                                  case.test_list,
                                  test_case_repeat)
            for test, output in zip(case.test_list, result):
                test_results[test] = output
        return test_results

    def _run_single_test(self,
                         test_name: str,
                         test_case_class: object
                         ) -> bool:
        """
        Run single test

        Args:
            test_name (string): Test name
            test_case_class (TestCase): unittest TestCase class instance

        Returns:
            True (bool): Test pass
            False (bool): Test fail
        """
        runner = HTMLTestRunner(report_name=test_name, output=self.dir_name)
        result = runner.run(test_case_class(test_name))
        if result.wasSuccessful():
            return True
        return False

    def _get_case_status_code(self, case_test_results: dict) -> int:
        """
        Get case status code and rename report files (PASS/FAIL)

        Args:
            case_test_results (dict): Case test results

        Returns:
            status_code (int): Status code
        """
        status_code = 0
        for test_name, result in case_test_results.items():
            if not result:
                self._report_files_rename(test_name, 'FAIL')
                status_code = 1
            else:
                self._report_files_rename(test_name, 'PASS')
        return status_code

    def _report_files_rename(self, test_name: str, status: str) -> None:
        """
        Get case status code and rename report files (PASS/FAIL)

        Args:
            test_name (str): Test name
            status (str): Status prefix
        """
        for file_name in os.listdir(self.dir_name):
            if test_name in file_name:
                new_file_name = f"{status}_{file_name}"
                os.rename(f"{self.dir_name}/{file_name}",
                          f"{self.dir_name}/{new_file_name}")


def main():
    suite = Suite(os.environ.get('SUITE_NAME'),
                  os.environ.get('NUMBER_OF_THREADS'))
    suite.add_case(MoveDevice)
    suite.add_case(Permissions)
    suite.add_case(AddDevice)
    suite.add_case(NameDuplication)
    status_code = suite.run_suite()
    sys.exit(status_code)


if __name__ == '__main__':
    main()
